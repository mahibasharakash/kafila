<?php

namespace App\Http\Controllers;

use App\Models\ToDoTask;
use App\Models\TrackingTrafficSource;
use App\Models\Visit;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{

    public function toDoIndex(): JsonResponse
    {
        $todo = ToDoTask::all();
        return response()->json(['success' => true, 'data' => $todo]);
    }

    public function toDoCreate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'task' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $todo = ToDoTask::create($data);
        return response()->json(['success' => true, 'data' => $todo], 201);
    }

    public function toDoDelete(string $id): JsonResponse
    {
        $todo = ToDoTask::find($id);
        if(!$todo) {
            return response()->json([ 'success' => false, 'message' => 'Task not found.' ], 404);
        }
        DB::beginTransaction();
        try {
            $todo->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong during deletion.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function toDoStatus(Request $request, string $id): JsonResponse
    {
        $todo = ToDoTask::find($id);
        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found.'
            ], 404);
        }
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:incomplete,completed',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $todo->status = $request->status;
        $todo->save();
        return response()->json([
            'success' => true,
            'data' => $todo
        ]);
    }

    public function visitStore(Request $request): JsonResponse
    {
        $request->validate([ 'page' => 'required|string|max:255' ]);
        Visit::create([ 'page' => $request->page ]);
        return response()->json(['message' => 'Visit recorded'], 201);
    }

    public function visitIndex(): JsonResponse
    {
        $visits = Visit::select('page')->selectRaw('count(*) as count')->groupBy('page')->get();
        return response()->json($visits);
    }

    public function socialMediaTrafficIndex(): JsonResponse
    {
        $platforms = ['Facebook', 'Twitter', 'Instagram', 'Linkedin', 'YouTube'];
        $data = TrackingTrafficSource::whereIn('source', $platforms)->get();
        $total = $data->sum('count');
        $traffic = [];
        foreach ($platforms as $platform) {
            $sourceData = $data->firstWhere('source', $platform);
            $count = $sourceData?->count ?? 0;
            $traffic[strtolower($platform)] = [
                'percent' => $total > 0 ? round(($count / $total) * 100) : 0,
                'count' => $count
            ];
        }
        return response()->json($traffic);
    }

    public function totalCount(Request $request): JsonResponse
    {
        $period = $request->get('period', 'monthly');
        $now = Carbon::now();

        // Define dynamic period ranges
        switch ($period) {
            case 'weekly':
                $startDate = $now->copy()->subDays(7);
                $prevStartDate = $now->copy()->subDays(14);
                $prevEndDate = $now->copy()->subDays(7);
                break;

            case 'yearly':
                $startDate = $now->copy()->subYear();
                $prevStartDate = $now->copy()->subYears(2);
                $prevEndDate = $now->copy()->subYear();
                break;

            case 'monthly':
            default:
                $startDate = $now->copy()->subDays(30);
                $prevStartDate = $now->copy()->subDays(60);
                $prevEndDate = $now->copy()->subDays(30);
                break;
        }

        // Total counts (lifetime)
        $totalCustomers = User::where('user_type', 'Customer')->count();
        $totalOrders = Order::count();
        $totalReturns = Order::where('status', 'returned')->count();

        // Total revenue (lifetime, excluding returned orders)
        $totalRevenue = Order::where('status', '!=', 'returned')
            ->select(DB::raw('SUM(CAST(price AS DECIMAL(10,2)) * CAST(quantity AS DECIMAL(10,2))) as total'))
            ->first()->total ?? 0;

        // Customer growth
        $newCustomersThisPeriod = User::where('user_type', 'Customer')
            ->where('created_at', '>=', $startDate)->count();

        $newCustomersPrevPeriod = User::where('user_type', 'Customer')
            ->whereBetween('created_at', [$prevStartDate, $prevEndDate])->count();

        $customerGrowth = $this->calculateGrowth($newCustomersThisPeriod, $newCustomersPrevPeriod);

        // Order stats for the current period
        $ordersThisPeriodTotal = Order::where('created_at', '>=', $startDate)->count();
        $ordersReturnedThisPeriod = Order::where('status', 'returned')
            ->where('created_at', '>=', $startDate)->count();
        $ordersSuccessThisPeriod = $ordersThisPeriodTotal - $ordersReturnedThisPeriod;

        // Proportional distribution
        $ordersGrowth = $ordersThisPeriodTotal > 0
            ? round(($ordersSuccessThisPeriod / $ordersThisPeriodTotal) * 100, 2)
            : 0.0;

        $returnsGrowth = $ordersThisPeriodTotal > 0
            ? round(($ordersReturnedThisPeriod / $ordersThisPeriodTotal) * 100, 2)
            : 0.0;

        // Revenue growth (excluding returned)
        $revenueThisPeriod = Order::where('created_at', '>=', $startDate)
            ->where('status', '!=', 'returned')
            ->select(DB::raw('SUM(CAST(price AS DECIMAL(10,2)) * CAST(quantity AS DECIMAL(10,2))) as total'))
            ->first()->total ?? 0;

        $revenuePrevPeriod = Order::whereBetween('created_at', [$prevStartDate, $prevEndDate])
            ->where('status', '!=', 'returned')
            ->select(DB::raw('SUM(CAST(price AS DECIMAL(10,2)) * CAST(quantity AS DECIMAL(10,2))) as total'))
            ->first()->total ?? 0;

        $revenueGrowth = $this->calculateGrowth($revenueThisPeriod, $revenuePrevPeriod);

        return response()->json([
            'total_customers' => $totalCustomers,
            'total_orders' => $totalOrders,
            'total_returns' => $totalReturns,
            'total_revenue' => number_format($totalRevenue, 2),

            'customer_growth' => $customerGrowth,
            'orders_growth' => $ordersGrowth,
            'returns_growth' => $returnsGrowth,
            'revenue_growth' => $revenueGrowth,
        ]);
    }

    private function calculateGrowth($current, $previous): float
    {
        if ($previous == 0 && $current > 0) return 100.0;
        if ($previous == 0 && $current == 0) return 0.0;
        return round((($current - $previous) / $previous) * 100, 2);
    }

    public function revenueGrowth(Request $request): JsonResponse
    {
        $period = $request->get('period', 'weekly');
        $now = Carbon::now();
        $query = Order::where('status', '!=', 'returned');

        switch ($period) {
            case 'weekly':
                $startDate = $now->copy()->startOfWeek();
                $data = $query->where('created_at', '>=', $startDate)
                    ->selectRaw("
                    DAYNAME(created_at) as label,
                    SUM(CAST(price AS DECIMAL(10,2)) * CAST(quantity AS DECIMAL(10,2))) as total
                ")
                    ->groupBy('label')
                    ->orderByRaw("FIELD(label, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
                    ->get();
                break;

            case 'monthly':
                $startDate = $now->copy()->startOfYear();
                $data = $query->where('created_at', '>=', $startDate)
                    ->selectRaw("
                    MONTHNAME(created_at) as label,
                    SUM(CAST(price AS DECIMAL(10,2)) * CAST(quantity AS DECIMAL(10,2))) as total
                ")
                    ->groupBy('label')
                    ->orderByRaw("FIELD(label, 'January','February','March','April','May','June','July','August','September','October','November','December')")
                    ->get();
                break;

            case 'yearly':
            default:
                $startDate = $now->copy()->subYears(5)->startOfYear();
                $data = $query->where('created_at', '>=', $startDate)
                    ->selectRaw("
                    YEAR(created_at) as label,
                    SUM(CAST(price AS DECIMAL(10,2)) * CAST(quantity AS DECIMAL(10,2))) as total
                ")
                    ->groupBy('label')
                    ->orderBy('label')
                    ->get();
                break;
        }

        $labels = [];
        $values = [];

        foreach ($data as $row) {
            $labels[] = $row->label;
            $values[] = (float) $row->total;
        }

        return response()->json([
            'labels' => $labels,
            'values' => $values,
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function index(): JsonResponse
    {
        $user = Auth::user();
        if ($user->user_type === 'Admin') {
            $orders = Order::with(['customer','product'])->get();
            $groupedOrders = $orders->groupBy(function ($order) {
                return $order->customer_id . '|' . $order->created_at->format('d-m-Y');
            });
            $data = $groupedOrders->map(function ($group) {
                $first = $group->first();
                return [
                    'id' => $first->id,
                    'customer' => [
                        'name' => $first->customer->name ?? '',
                        'phone' => $first->customer->phone ?? '',
                        'address' => $first->customer->address ?? '',
                    ],
                    'payment_method' => $first->payment_method ?? '',
                    'items' => $group->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'title' => $item->title,
                            'price' => $item->price,
                            'quantity' => $item->quantity,
                            'status' => $item->status,
                            'orderDate' => $item->created_at->format('d-m-Y'),
                        ];
                    })->values()
                ];
            })->values();
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } else {
            $orders = Order::where('customer_id', $user->id)->get();
            return response()->json([ 'success' => true, 'data' => $orders ]);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:users,id',
            'payment_method' => 'required|string',
            'orders' => 'required|array|min:1',
            'orders.*.product_id' => 'required|exists:products,id',
            'orders.*.image' => 'required|string',
            'orders.*.title' => 'required|string',
            'orders.*.category' => 'required|string',
            'orders.*.price' => 'required',
            'orders.*.quantity' => 'required|integer|min:1',
            'orders.*.status' => 'required|in:pending,complete,on progress',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $quantityErrors = [];
        foreach ($request->input('orders') as $index => $order) {
            $product = Product::find($order['product_id']);
            if ($product && $product->quantity < $order['quantity']) {
                $quantityErrors["orders.$index.quantity"] = ["Not enough quantity in this product"];
            }
        }
        if (!empty($quantityErrors)) {
            return response()->json(['success' => false, 'errors' => $quantityErrors], 422);
        }
        $customerId = $request->input('customer_id');
        $paymentMethod = $request->input('payment_method'); // ✅ Correctly use top-level payment method
        $ordersData = [];
        DB::beginTransaction();
        try {
            foreach ($request->input('orders') as $order) {
                $product = Product::find($order['product_id']);
                $product->quantity -= $order['quantity'];
                $product->save();
                $ordersData[] = [
                    'customer_id' => $customerId,
                    'image' => $order['image'],
                    'title' => $order['title'],
                    'price' => $order['price'],
                    'category' => $order['category'],
                    'quantity' => $order['quantity'],
                    'status' => $order['status'],
                    'payment_method' => $paymentMethod, // ✅ Apply here
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            Order::insert($ordersData);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Orders created successfully.'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Order creation failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([ 'success' => false, 'message' => 'Box not found.' ], 404);
        }
        return response()->json([ 'success' => true, 'data' => $order ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.'
            ], 404);
        }
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,on progress,complete,returned',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $order->status = $request->status;
        $order->save();
        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    public function clear(): JsonResponse
    {
        try {
            DB::transaction(function () {
                $allData = Order::all();
                foreach ($allData as $data) {
                    if ($data->image) {
                        $this->deleteImage($data->image);
                    }
                }
            });
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Order::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return response()->json([
                'success' => true,
                'message' => 'All boxes have been truncated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to truncate boxes.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function deleteImage(string $imageUrl): void
    {
        $path = str_replace('/storage/', '', parse_url($imageUrl, PHP_URL_PATH));
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

}

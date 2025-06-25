<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{

    public function index(): JsonResponse
    {
        $customer = User::where('user_type', 'Customer')->get();
        return response()->json(['success' => true, 'data' => $customer]);
    }

    public function show(string $id): JsonResponse
    {
        $category = User::find($id);
        if (!$category) {
            return response()->json([ 'success' => false, 'message' => 'Data not found.' ], 404);
        }
        return response()->json([ 'success' => true, 'data' => $category ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $category = User::find($id);
        if (!$category) {
            return response()->json([ 'success' => false, 'message' => 'Data not found.' ], 404);
        }
        DB::beginTransaction();
        try {
            if ($category->image) {
                $this->deleteImage($category->image);
            }
            $category->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data deleted successfully.'
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

    private function deleteImage(string $imageUrl): void
    {
        $path = str_replace('/storage/', '', parse_url($imageUrl, PHP_URL_PATH));
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function clear(): JsonResponse
    {
        try {
            DB::transaction(function () {
                $customers = User::where('user_type', 'Customer')->get();
                foreach ($customers as $customer) {
                    if ($customer->image) {
                        $this->deleteImage($customer->image);
                    }
                }
                User::where('user_type', 'Customer')->delete();
            });
            return response()->json([
                'success' => true,
                'message' => 'All data have been deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index(): JsonResponse
    {
        $product = Product::with(['category', 'brand'])->get();
        return response()->json(['success' => true, 'data' => $product]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'image' => 'sometimes|file|max:2048',
            'title' => 'required|string|max:255',
            'price' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'quantity' => 'required',
            'product_type' => 'nullable|in:featured_products,latest_products,best_sellers',
            'description' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $data = $validator->validated();
        if (isset($data['description']) && is_string($data['description'])) {
            $decoded = json_decode($data['description'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data['description'] = $decoded;
            }
        }
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('', 'public');
            $data['image'] = Storage::url($path);
        }
        $product = Product::create($data);
        return response()->json([
            'success' => true,
            'data' => $product
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $product = Product::with(['category', 'brand'])->find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }
        if (is_string($product->description)) {
            $decoded = json_decode($product->description, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $product->description = $decoded;
            }
        }
        return response()->json(['success' => true, 'data' => $product]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }
        $validator = Validator::make($request->all(), [
            'image' => 'sometimes|file|max:2048',
            'title' => 'required|string|max:255',
            'price' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'quantity' => 'required',
            'product_type' => 'nullable|in:featured_products,latest_products,best_sellers',
            'description' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $data = $validator->validated();
        if (isset($data['description']) && is_string($data['description'])) {
            $decoded = json_decode($data['description'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data['description'] = $decoded;
            }
        }
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                if ($product->image) {
                    $this->deleteImage($product->image);
                }
                $path = $request->file('image')->store('', 'public');
                $data['image'] = Storage::url($path);
            }
            $product->update($data);
            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $product
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong during update.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        $box = Product::find($id);
        if (!$box) {
            return response()->json([ 'success' => false, 'message' => 'Product not found.' ], 404);
        }
        DB::beginTransaction();
        try {
            if ($box->image) {
                $this->deleteImage($box->image);
            }
            $box->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully.'
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
                $allData = Product::all();
                foreach ($allData as $data) {
                    if ($data->image) {
                        $this->deleteImage($data->image);
                    }
                }
            });
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Product::truncate();
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

}

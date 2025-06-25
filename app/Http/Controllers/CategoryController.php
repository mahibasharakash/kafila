<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function index(): JsonResponse
    {
        $category = Category::all();
        return response()->json(['success' => true, 'data' => $category]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|file|max:2048',
            'name' => 'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        if($request->hasFile('image')){
            $path = $request->file('image')->store('', 'public');
            $data['image'] = Storage::url($path);
        }
        $category = Category::create($data);
        return response()->json(['success' => true, 'data' => $category], 201);
    }

    public function show(string $id): JsonResponse
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([ 'success' => false, 'message' => 'Category not found.' ], 404);
        }
        return response()->json([ 'success' => true, 'data' => $category ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([ 'success' => false, 'message' => 'Category not found.' ], 404);
        }
        $validator = Validator::make($request->all(), [
            'image' => 'required|file|max:2048',
            'name' => 'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                if ($category->image) {
                    $this->deleteImage($category->image);
                }
                $path = $request->file('image')->store('', 'public');
                $data['image'] = Storage::url($path);
            }
            $category->update($data);
            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $category
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
        $category = Category::find($id);
        if (!$category) {
            return response()->json([ 'success' => false, 'message' => 'Category not found.' ], 404);
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
                'message' => 'Category deleted successfully.'
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
                $allData = Category::all();
                foreach ($allData as $data) {
                    if ($data->image) {
                        $this->deleteImage($data->image);
                    }
                }
            });
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Category::truncate();
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

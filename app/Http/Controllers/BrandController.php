<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{

    public function index(): JsonResponse
    {
        $category = Brand::all();
        return response()->json(['success' => true, 'data' => $category]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $category = Brand::create($data);
        return response()->json(['success' => true, 'data' => $category], 201);
    }

    public function show(string $id): JsonResponse
    {
        $category = Brand::find($id);
        if (!$category) {
            return response()->json([ 'success' => false, 'message' => 'Brand not found.' ], 404);
        }
        return response()->json([ 'success' => true, 'data' => $category ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $category = Brand::find($id);
        if (!$category) {
            return response()->json([ 'success' => false, 'message' => 'Brand not found.' ], 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $category->update($data);
        return response()->json(['success' => true, 'data' => $category]);
    }

    public function destroy(string $id): JsonResponse
    {
        $category = Brand::find($id);
        try {
            if (!$category) {
                return response()->json([ 'success' => false, 'message' => 'Brand not found.' ], 404);
            }
            $category->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Brand deleted successfully.'
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

    public function clear(): JsonResponse
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Brand::truncate();
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

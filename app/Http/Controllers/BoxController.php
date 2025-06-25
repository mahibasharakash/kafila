<?php

namespace App\Http\Controllers;

use App\Models\Box;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BoxController extends Controller
{

    public function index(): JsonResponse
    {
        $boxes = Box::all();
        return response()->json(['success' => true, 'data' => $boxes]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|file|max:2048',
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
        ]);
        if ($validator->fails()) {
            return response()->json([ 'success' => false, 'errors' => $validator->errors() ], 422);
        }
        $data = $validator->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('', 'public');
            $data['image'] = Storage::url($path);
        }
        $box = Box::create($data);
        return response()->json([ 'success' => true, 'data' => $box ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $box = Box::find($id);
        if (!$box) {
            return response()->json([ 'success' => false, 'message' => 'Box not found.' ], 404);
        }
        return response()->json([ 'success' => true, 'data' => $box ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $box = Box::find($id);
        if (!$box) {
            return response()->json([ 'success' => false, 'message' => 'Box not found.' ], 404);
        }
        $validator = Validator::make($request->all(), [
            'image' => 'sometimes|file|max:2048',
            'title' => 'sometimes|string|max:255',
            'short_description' => 'nullable|string|max:500',
        ]);
        if ($validator->fails()) {
            return response()->json([ 'success' => false, 'errors' => $validator->errors() ], 422);
        }
        $data = $validator->validated();
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                if ($box->image) {
                    $this->deleteImage($box->image);
                }
                $path = $request->file('image')->store('', 'public');
                $data['image'] = Storage::url($path);
            }
            $box->update($data);
            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $box
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
        $box = Box::find($id);
        if (!$box) {
            return response()->json([ 'success' => false, 'message' => 'Box not found.' ], 404);
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
                'message' => 'Box deleted successfully.'
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
                $allData = Box::all();
                foreach ($allData as $data) {
                    if ($data->image) {
                        $this->deleteImage($data->image);
                    }
                }
            });
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Box::truncate();
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

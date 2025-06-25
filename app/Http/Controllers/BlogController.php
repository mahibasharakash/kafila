<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{

    public function index(): JsonResponse
    {
        $blog = Blog::all();
        return response()->json(['success' => true, 'data' => $blog]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required',
            'tags' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|string|max:255',
            'publish_date' => 'required|string|max:255',
            'publish_time' => 'required|string|max:255',
            'image' => 'sometimes|file|max:2048',
            'short_description' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        if (is_string($validated['description'])) {
            $decoded = json_decode($validated['description'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $validated['description'] = $decoded;
            }
        }
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('', 'public');
            $validated['image'] = Storage::url($path);
        }
        $blog = Blog::create($validated);
        return response()->json(['success' => true, 'data' => $blog], 201);
    }

    public function show(string $id): JsonResponse
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json([ 'success' => false, 'message' => 'Blog not found.' ], 404);
        }
        if (is_string($blog->description)) {
            $decoded = json_decode($blog->description, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $blog->description = $decoded;
            }
        }
        return response()->json([ 'success' => true, 'data' => $blog ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['success' => false, 'message' => 'Blog not found.'], 404);
        }
        $data = $request->all();
        if (isset($data['tags']) && is_array($data['tags'])) {
            $data['tags'] = implode(', ', $data['tags']);
        }
        $validator = Validator::make($data, [
            'title' => 'required',
            'category' => 'required',
            'tags' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|string|max:255',
            'publish_date' => 'required|string|max:255',
            'publish_time' => 'required|string|max:255',
            'image' => 'sometimes|file|max:2048',
            'short_description' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        if (is_string($validated['description'])) {
            $decoded = json_decode($validated['description'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $validated['description'] = $decoded;
            }
        }
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                if ($blog->image) {
                    $this->deleteImage($blog->image);
                }
                $path = $request->file('image')->store('', 'public');
                $validated['image'] = Storage::url($path);
            }

            $blog->update($validated);
            DB::commit();
            return response()->json(['success' => true, 'data' => $blog]);
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
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json([ 'success' => false, 'message' => 'Blog not found.' ], 404);
        }
        DB::beginTransaction();
        try {
            if ($blog->image) {
                $this->deleteImage($blog->image);
            }
            $blog->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Blog deleted successfully.'
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
            DB::transaction(function () {
                $allData = Blog::all();
                foreach ($allData as $data) {
                    if ($data->image) {
                        $this->deleteImage($data->image);
                    }
                }
            });
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Blog::truncate();
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

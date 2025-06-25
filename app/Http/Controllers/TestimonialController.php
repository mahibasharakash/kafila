<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends BaseController
{

    public function index(): JsonResponse
    {
        $testimonial = Testimonial::all();
        return response()->json(['success' => true, 'data' => $testimonial]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|file|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        if($request->hasFile('image')){
            $path = $request->file('image')->store('', 'public');
            $data['image'] = Storage::url($path);
        }
        $testimonial = Testimonial::create($data);
        return response()->json(['success' => true, 'data' => $testimonial], 201);
    }

    public function show(string $id): JsonResponse
    {
        $testimonial = Testimonial::find($id);
        if (!$testimonial) {
            return response()->json([ 'success' => false, 'message' => 'Testimonial not found.' ], 404);
        }
        return response()->json([ 'success' => true, 'data' => $testimonial ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $testimonial = Testimonial::find($id);
        if (!$testimonial) {
            return response()->json([ 'success' => false, 'message' => 'Testimonial not found.' ], 404);
        }
        $validator = Validator::make($request->all(), [
            'image' => 'required|file|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                if ($testimonial->image) {
                    $this->deleteImage($testimonial->image);
                }
                $path = $request->file('image')->store('', 'public');
                $data['image'] = Storage::url($path);
            }
            $testimonial->update($data);
            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $testimonial
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
        $testimonial = Testimonial::find($id);
        if (!$testimonial) {
            return response()->json([ 'success' => false, 'message' => 'Testimonial not found.' ], 404);
        }
        DB::beginTransaction();
        try {
            if ($testimonial->image) {
                $this->deleteImage($testimonial->image);
            }
            $testimonial->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Testimonial deleted successfully.'
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
                $allData = Testimonial::all();
                foreach ($allData as $data) {
                    if ($data->image) {
                        $this->deleteImage($data->image);
                    }
                }
            });
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Testimonial::truncate();
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

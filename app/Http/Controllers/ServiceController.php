<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{

    public function index(): JsonResponse
    {
        $service = Service::all();
        return response()->json(['success' => true, 'data' => $service]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'image' => 'sometimes|file|max:2048',
            'tags' => 'required|string|max:255',
            'title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([ 'success' => false, 'errors' => $validator->errors() ], 422);
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
        $service = Service::create($data);
        return response()->json([ 'success' => true, 'data' => $service ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $service = Service::find($id);
        if (!$service) {
            return response()->json([ 'success' => false, 'message' => 'Service not found.' ], 404);
        }
        if (is_string($service->description)) {
            $decoded = json_decode($service->description, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $service->description = $decoded;
            }
        }
        return response()->json([ 'success' => true, 'data' => $service ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $service = Service::find($id);
        if (!$service) {
            return response()->json([ 'success' => false, 'message' => 'Service not found.' ], 404);
        }
        $validator = Validator::make($request->all(), [
            'image' => 'sometimes|file|max:2048',
            'tags' => 'required|string|max:255',
            'title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([ 'success' => false, 'errors' => $validator->errors() ], 422);
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
                if ($service->image) {
                    $this->deleteImage($service->image);
                }
                $path = $request->file('image')->store('', 'public');
                $data['image'] = Storage::url($path);
            }
            $service->update($data);
            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $service
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
        $service = Service::find($id);
        if (!$service) {
            return response()->json([ 'success' => false, 'message' => 'Service not found.' ], 404);
        }
        DB::beginTransaction();
        try {
            if ($service->image) {
                $this->deleteImage($service->image);
            }
            $service->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Service deleted successfully.'
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
                $allData = Service::all();
                foreach ($allData as $data) {
                    if ($data->image) {
                        $this->deleteImage($data->image);
                    }
                }
            });
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Service::truncate();
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

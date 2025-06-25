<?php

namespace App\Http\Controllers;

use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class GeneralSettingsController extends BaseController
{

    /**
     * Display the specified general settings.
     */
    public function show($id): JsonResponse
    {
        $setting = GeneralSettings::find($id);
        if (!$setting) {
            return response()->json(['success' => false, 'message' => 'Setting not found.'], 404);
        }
        return response()->json(['success' => true, 'data' => $setting]);
    }

    /**
     * Store a newly created general setting.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data = $this->handleFileUploads($request, $data);

        $setting = GeneralSettings::create($data);

        return response()->json(['success' => true, 'data' => $setting], 201);
    }

    /**
     * Update the specified general setting.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $setting = GeneralSettings::find($id);

        if (!$setting) {
            return response()->json(['success' => false, 'message' => 'Setting not found.'], 404);
        }

        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data = $this->handleFileUploads($request, $data);

        $setting->update($data);

        return response()->json(['success' => true, 'data' => $setting]);
    }

    /**
     * Central validation rules used in store and update.
     */
    private function rules(): array
    {
        return [
            'logo_file_path' => 'nullable|file|max:2048',
            'logo_name' => 'nullable|string',
            'short_description' => 'nullable',
            'long_description' => 'nullable',
            'location' => 'nullable',
            'cover_file_path' => 'nullable',
            'breadcrumb_file_path' => 'nullable',

            'times' => 'nullable|array',
            'times.*.working_time' => 'required|string',

            'phone_numbers' => 'nullable|array',
            'phone_numbers.*.phone' => 'required|string',

            'emails' => 'nullable|array',
            'emails.*.email' => 'required|email',

            'timelines' => 'nullable|array',
            'timelines.*.year' => 'required|string',
            'timelines.*.timeline' => 'required|string',
            'timelines.*.short_description' => 'required|string',

            'slider_file_path' => 'nullable|file|max:2048',
            'video_file_path' => 'nullable|file|max:51200',

            'slider_small_title' => 'nullable|string',
            'slider_big_title' => 'nullable|string',
            'slider_text_color' => 'nullable|string',
            'slider_background_opacity' => 'nullable|string',
            'slider_small_short_description' => 'nullable',
        ];
    }

    /**
     * Handle file uploads and return updated data array.
     */
    private function handleFileUploads(Request $request, array $data): array
    {
        $fileFields = ['logo_file_path', 'cover_file_path', 'slider_file_path', 'video_file_path','breadcrumb_file_path'];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('', $filename, 'public');
                $data[$field] = Storage::url($path);
            }
        }

        return $data;
    }

}

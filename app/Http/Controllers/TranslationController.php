<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TranslationController extends Controller
{

    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Translation::all();
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'en' => 'required|string|unique:translations,en',
            'ar' => 'required|string',
        ]);
        $translation = Translation::create($data);
        $this->exportTranslations();
        return response()->json($translation, 201);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $translation = Translation::findOrFail($id);
        return response()->json($translation);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $translation = Translation::findOrFail($id);
        $data = $request->validate([
            'en' => 'required|string|unique:translations,en,' . $translation->id,
            'ar' => 'required|string',
        ]);
        $translation->update($data);
        $this->exportTranslations();

        return response()->json($translation);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $translation = Translation::findOrFail($id);
        $translation->delete();
        $this->exportTranslations();
        return response()->json(['message' => 'Translation deleted']);
    }

    public function clear(): JsonResponse
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Translation::truncate();
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

    protected function exportTranslations(): void
    {
        $translations = Translation::all();
        $en = $translations->pluck('en', 'en')->toArray();
        $ar = $translations->pluck('ar', 'en')->toArray();
        File::put(resource_path('language/en.json'), json_encode($en, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        File::put(resource_path('language/ar.json'), json_encode($ar, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

}

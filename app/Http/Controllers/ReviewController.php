<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Blog;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{

    protected $typeMap = [
        'product' => Product::class,
        'blog' => Blog::class,
        'service' => Service::class,
    ];

    public function index(Request $request): JsonResponse
    {
        $type = $request->query('type');
        $id = $request->query('id');
        if ($type) {
            if (!array_key_exists($type, $this->typeMap)) {
                return response()->json(['success' => false, 'message' => 'Invalid type.'], 400);
            }
            $modelClass = $this->typeMap[$type];
            $query = Review::where('reviewable_type', $modelClass);
            if ($id) {
                $query->where('reviewable_id', $id);
            }
            $reviews = $query->latest()->get();
            $cleaned = $reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'reviewable_id' => $review->reviewable_id,
                    'type' => strtolower(class_basename($review->reviewable_type)),
                    'name' => $review->name,
                    'message' => $review->message,
                    'created_at' => $review->created_at->toDateTimeString(),
                ];
            });
        } else {
            $reviews = Review::with('reviewable')->latest()->get();
            $grouped = $reviews->groupBy(function ($review) {
                return $review->reviewable_type . ':' . $review->reviewable_id;
            });
            $cleaned = $grouped->map(function ($group) {
                $firstReview = $group->first();
                return [
                    'reviewable_id' => $firstReview->reviewable_id,
                    'type' => strtolower(class_basename($firstReview->reviewable_type)),
                    'related_data' => $firstReview->reviewable,
                    'reviews' => $group->map(function ($review) {
                        return [
                            'id' => $review->id,
                            'name' => $review->name,
                            'message' => $review->message,
                            'created_at' => $review->created_at->toDateTimeString(),
                        ];
                    })->values(),
                ];
            })->values();
        }
        return response()->json(['success' => true, 'data' => $cleaned]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:product,blog,service',
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $modelClass = $this->typeMap[$data['type']];
        $reviewable = $modelClass::find($data['id']);
        if (!$reviewable) {
            return response()->json(['success' => false, 'message' => 'Target not found.'], 404);
        }
        DB::beginTransaction();
        try {
            $review = $reviewable->reviews()->create([
                'name' => $data['name'],
                'message' => $data['message'],
            ]);
            DB::commit();
            return response()->json(['success' => true, 'data' => $review], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create review.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['success' => false, 'message' => 'Review not found.'], 404);
        }
        return response()->json(['success' => true, 'data' => $review]);
    }

    public function destroy(string $id): JsonResponse
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['success' => false, 'message' => 'Review not found.'], 404);
        }
        DB::beginTransaction();
        try {
            $review->delete();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Review deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete review.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function clear(): JsonResponse
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Review::truncate();
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

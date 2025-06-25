<?php

namespace App\Http\Controllers;


use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ContactController extends BaseController
{

    public function index(): JsonResponse
    {
        $contact = Contact::all();
        return response()->json(['success' => true, 'data' => $contact]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'message' => 'required|string|max:500',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $contact = Contact::create($data);
        return response()->json(['success' => true, 'data' => $contact], 201);
    }

    public function show(string $id): JsonResponse
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json([ 'success' => false, 'message' => 'Contact not found.' ], 404);
        }
        return response()->json([ 'success' => true, 'data' => $contact ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $contact = Contact::find($id);
        try {
            if (!$contact) {
                return response()->json([ 'success' => false, 'message' => 'Contact not found.' ], 404);
            }
            $contact->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Contact deleted successfully.'
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
            Contact::truncate();
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

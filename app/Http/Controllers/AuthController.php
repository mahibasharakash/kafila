<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;

class AuthController extends BaseController
{

    use HasApiTokens;

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (!Auth::attempt($credentials)) {
            return response()->json(['credential' => 'Invalid credentials'], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'user' => $user,
            'user_type' => $user->user_type,
            'message' => 'Login successful'
        ]);
    }

    public function registration(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'required|min:6|confirmed',
            'user_type' => 'required|in:Admin,Customer'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
        ]);
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'user_type' => $user->user_type
        ]);
    }

    public function forgot(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Email not found'], 404);
        }
        $verificationCode = Str::random(6);
        $user->update(['verification_code' => $verificationCode]);
        Mail::raw("Your verification code is: " . $verificationCode, function (Message $message) use ($user) {
            $message->to($user->email)->subject('Your Verification Code');
        });
        return response()->json([
            'message' => 'Verification code sent to email',
            'verification_code' => $verificationCode,
        ]);
    }

    public function verification(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if ($user->verification_code !== $request->verification_code) {
            return response()->json(['message' => 'Invalid verification code'], 400);
        }
        $resetCode = Str::random(6);
        $user->update([
            'reset_code' => $resetCode,
            'verification_code' => null,
            'email_verified_at' => Carbon::now()
        ]);
        Mail::raw("Your reset code is: " . $resetCode, function (Message $message) use ($user) {
            $message->to($user->email)
                ->subject('Your Reset Code');
        });
        return response()->json(['message' => 'Verification successful. Reset code sent to email']);
    }

    public function reset(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'reset_code' => 'required',
            'password' => 'required|string|min:6|confirmed'
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if ($user->reset_code !== $request->reset_code) {
            return response()->json(['message' => 'Invalid reset code'], 400);
        }
        $user->update(['password' => Hash::make($request->password), 'reset_code' => null]);
        return response()->json(['message' => 'Password reset successfully']);
    }

    public function details(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user) { return response()->json(['message' => 'Not authenticated'], 401); }
        return response()->json([
            'user' => $user,
            'user_type' => $user->user_type
        ]);
    }

    public function changeDetails(Request $request): JsonResponse
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string',
            'image' => 'nullable|file|image|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }
        $data = $validator->validated();
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                if ($user->image) {
                    $this->deleteImage($user->image);
                }

                $path = $request->file('image')->store('', 'public');
                $data['image'] = Storage::url($path);
            }
            $user->update($data);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'User details updated successfully',
                'user' => $user->only(['id', 'name', 'phone', 'address', 'email', 'image']),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong during update.',
                'error' => $e->getMessage(),
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

    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);
        $user = $request->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Incorrect current password'], 400);
        }
        $user->update(['password' => Hash::make($request->new_password)]);
        return response()->json(['message' => 'Password changed successfully']);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($user) {
            $user->tokens->each(function ($token) { $token->delete(); });
            return response()->json([ 'message' => 'Logout successful' ]);
        }
        return response()->json(['message' => 'Not authenticated'], 401);
    }

}

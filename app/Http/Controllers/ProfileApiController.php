<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProfileApiController extends Controller
{
    /**
     * Get authenticated user's profile
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'profile_image_url' => $user->profile_image_url,
                'roles' => $user->roles->pluck('name'),
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ],
        ], 200);
    }

    /**
     * Update authenticated user's profile
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => __('users.profile.update_failed'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => __('users.profile.update_success'),
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'profile_image_url' => $user->profile_image_url,
                'roles' => $user->roles->pluck('name'),
                'updated_at' => $user->updated_at,
            ],
        ], 200);
    }

    /**
     * Change authenticated user's password
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => __('users.profile.update_failed'),
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => __('users.profile.current_password_incorrect'),
                'errors' => [
                    'current_password' => [__('users.profile.current_password_incorrect')],
                ],
            ], 422);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('users.profile.password_changed'),
        ], 200);
    }

    /**
     * Upload profile avatar
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadAvatar(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid image file',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Delete old profile image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        // Store new image
        $file = $request->file('avatar');
        $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('profile_images', $filename, 'public');

        // Update user profile_image
        $user->update(['profile_image' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Profile picture uploaded successfully',
            'data' => [
                'profile_image_url' => $user->fresh()->profile_image_url,
            ],
        ], 200);
    }

    /**
     * Delete profile avatar
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAvatar(Request $request)
    {
        $user = $request->user();

        if (!$user->profile_image) {
            return response()->json([
                'success' => false,
                'message' => 'No profile picture to delete',
            ], 404);
        }

        // Delete file from storage
        Storage::disk('public')->delete($user->profile_image);

        // Clear profile_image field
        $user->update(['profile_image' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Profile picture deleted successfully',
        ], 200);
    }
}

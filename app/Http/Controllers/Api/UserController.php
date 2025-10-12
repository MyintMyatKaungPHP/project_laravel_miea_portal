<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $users = User::with('roles')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->when($request->email_verified, function ($query, $verified) {
                if ($verified === 'true') {
                    $query->whereNotNull('email_verified_at');
                } elseif ($verified === 'false') {
                    $query->whereNull('email_verified_at');
                }
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $users,
        ], 200);
    }

    /**
     * Store a newly created user
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,name'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = 'profile_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('users/profiles', $filename, 'public');
            $data['profile_image'] = $path;
        }

        // Hash password
        $data['password'] = Hash::make($data['password']);

        // Create user
        $user = User::create($data);

        // Assign roles if provided
        if (isset($data['roles'])) {
            $user->assignRole($data['roles']);
        }

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user->load('roles'),
        ], 201);
    }

    /**
     * Display the specified user
     * 
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return response()->json([
            'success' => true,
            'data' => $user->load('roles'),
        ], 200);
    }

    /**
     * Update the specified user
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'email_verified_at' => ['nullable', 'date'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,name'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $file = $request->file('profile_image');
            $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('users/profiles', $filename, 'public');
            $data['profile_image'] = $path;
        }

        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Update user
        $user->update($data);

        // Sync roles if provided
        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => $user->fresh()->load('roles'),
        ], 200);
    }

    /**
     * Remove the specified user
     * 
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        // Delete profile image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
        ], 200);
    }

    /**
     * Verify user email
     * 
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(User $user)
    {
        if ($user->email_verified_at) {
            return response()->json([
                'success' => false,
                'message' => 'User email already verified',
            ], 422);
        }

        $user->update(['email_verified_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'User email verified successfully',
            'data' => $user,
        ], 200);
    }

    /**
     * Unverify user email
     * 
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function unverify(User $user)
    {
        if (!$user->email_verified_at) {
            return response()->json([
                'success' => false,
                'message' => 'User email already unverified',
            ], 422);
        }

        $user->update(['email_verified_at' => null]);

        return response()->json([
            'success' => true,
            'message' => 'User email unverified successfully',
            'data' => $user,
        ], 200);
    }
}

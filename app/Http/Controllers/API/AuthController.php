<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
    * Login user and return token
    */
    public function login(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            $user = User::where('username', $validated['username'])->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid username or password',
                ], 401);
            }

            // Revoke existing tokens (optional - untuk single session)
            // $user->tokens()->delete();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => new UserResource($user),
                    'token' => $token,
                    'token_type' => 'Bearer',
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logout user (revoke token)
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logout successful'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get authenticated user profile
     */
    // public function profile(Request $request): JsonResponse
    // {
    //     try {
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Profile retrieved successfully',
    //             'data' => new UserResource($request->user())
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to get profile',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    /**
     * Update authenticated user profile
     */
    // public function updateProfile(Request $request): JsonResponse
    // {
    //     try {
    //         $user = $request->user();

    //         $validated = $request->validate([
    //             'name' => 'sometimes|string|max:255',
    //             'username' => 'sometimes|string|max:255|unique:users,username,' . $user->id,
    //             'password' => 'sometimes|string|min:6',
    //         ]);

    //         if (isset($validated['password'])) {
    //             $validated['password'] = Hash::make($validated['password']);
    //         }

    //         $user->update($validated);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Profile updated successfully',
    //             'data' => new UserResource($user->fresh())
    //         ]);

    //     } catch (ValidationException $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Validation failed',
    //             'errors' => $e->errors()
    //         ], 422);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to update profile',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    /**
     * Change password
     */
    // public function changePassword(Request $request): JsonResponse
    // {
    //     try {
    //         $validated = $request->validate([
    //             'current_password' => 'required|string',
    //             'new_password' => 'required|string|min:6|confirmed',
    //         ]);

    //         $user = $request->user();

    //         if (!Hash::check($validated['current_password'], $user->password)) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Current password is incorrect',
    //             ], 422);
    //         }

    //         $user->update([
    //             'password' => Hash::make($validated['new_password'])
    //         ]);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Password changed successfully'
    //         ]);

    //     } catch (ValidationException $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Validation failed',
    //             'errors' => $e->errors()
    //         ], 422);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to change password',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
}

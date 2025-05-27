<?php

namespace App\Http\Controllers\CustomerPortal;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerPortal\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerProfileController extends Controller
{
    /**
     * Get customer profile information.
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();
        $customer = $user->userable;

        return response()->json([
            'data' => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'customer' => [
                    'first_name' => $customer->first_name,
                    'last_name' => $customer->last_name,
                    'phone' => $customer->phone,
                    'address' => $customer->address,
                    'city' => $customer->city,
                    'state' => $customer->state,
                    'country' => $customer->country,
                    'postal_code' => $customer->postal_code,
                    'company_name' => $customer->company_name,
                    'status' => $customer->status,
                    'last_login' => $customer->last_login,
                    'created_at' => $customer->created_at,
                ]
            ]
        ]);
    }

    /**
     * Update customer profile information.
     */
    public function update(Request $request): JsonResponse
    {
        $user = $request->user();
        $customer = $user->userable;

        // Validate the request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
        ]);

        try {
            // Update user email
            $user->update([
                'email' => $validated['email'],
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            ]);

            // Update customer information
            $customer->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'company_name' => $validated['company_name'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'country' => $validated['country'],
                'postal_code' => $validated['postal_code'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => [
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                    ],
                    'customer' => [
                        'first_name' => $customer->first_name,
                        'last_name' => $customer->last_name,
                        'phone' => $customer->phone,
                        'address' => $customer->address,
                        'city' => $customer->city,
                        'state' => $customer->state,
                        'country' => $customer->country,
                        'postal_code' => $customer->postal_code,
                        'company_name' => $customer->company_name,
                        'status' => $customer->status,
                        'last_login' => $customer->last_login,
                        'created_at' => $customer->created_at,
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change customer password.
     */
    public function changePassword(Request $request): JsonResponse
    {
        $user = $request->user();

        // Validate the request
        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Check current password
            if (!Hash::check($validated['current_password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ], 401);
            }

            // Update password
            $user->update([
                'password' => Hash::make($validated['new_password'])
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to change password: ' . $e->getMessage()
            ], 500);
        }
    }
}

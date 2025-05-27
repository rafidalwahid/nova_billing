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
    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user = $request->user();
        $customer = $user->userable;

        // Update customer information
        $customer->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'company_name' => $request->company_name,
        ]);

        // Update user name and email if provided
        $userUpdates = [];
        if ($request->has('email') && $request->email !== $user->email) {
            $userUpdates['email'] = $request->email;
        }

        $userUpdates['name'] = $customer->first_name . ' ' . $customer->last_name;

        if (!empty($userUpdates)) {
            $user->update($userUpdates);
        }

        return response()->json([
            'data' => [
                'user' => [
                    'name' => $user->fresh()->name,
                    'email' => $user->fresh()->email,
                ],
                'customer' => $customer->fresh()
            ],
            'message' => 'Profile updated successfully.'
        ]);
    }

    /**
     * Change customer password.
     */
    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = $request->user();

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Password changed successfully.'
        ]);
    }
}

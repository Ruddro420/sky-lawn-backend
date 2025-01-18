<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRegister;
use Illuminate\Http\Request;

class UserRegisterController extends Controller
{
    public function user_data()
    {
        $user = UserRegister::all();
        return response()->json([
            'status' => 'success',
            'message' => 'User data',
            'data' => $user
        ]);
    }

    public function add_user(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required', // Validate as email and check uniqueness
                'email' => 'required|email|unique:user_registers,email', // Validate as email and check uniqueness
                'password' => 'required', // Validate as email and check uniqueness
            ]);
    
            // Create user record if validation passes
            $userData = UserRegister::create($validatedData);
    
            return response()->json([
                'status' => 'success',
                'message' => 'User added successfully',
                'data' => $userData
            ]);
    
        } catch (\Illuminate\Validation\ValidationException $exception) {
            // Return error response for validation failures
            return response()->json([
                'status' => 'error',
                'message' => $exception->errors(), // Provide validation error details
            ], 422); // Use 422 Unprocessable Entity for validation errors
        }
    }
    

    public function delete_user($id)
    {
        $user = UserRegister::find($id);
        $user->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Delete user'
        ]);
    }

    public function checking_user(Request $request)
    {
        // Fetch the user with the provided email
        $user = UserRegister::where('email', $request->email)->first();
    
        if ($user) {
            // Check if the provided password matches the stored password
            if ($request->password === $user->password) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'User found',
                    'data' => $user
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Incorrect password'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ]);
        }
    }
}

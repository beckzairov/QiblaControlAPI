<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    // Admin Access Route
    public function adminAccess()
    {
        return response()->json(['message' => 'Welcome Admin!'], 200);
    }

    // Manager Access Route
    public function managerAccess()
    {
        return response()->json(['message' => 'Welcome Manager!'], 200);
    }

    // Sale Operator Access Route
    public function saleOperatorAccess()
    {
        return response()->json(['message' => 'Welcome Sale Operator!'], 200);
    }

    // specialistAccess Access Route
    public function specialistAccess()
    {
        if (auth()->check()) {
            return response()->json(['message' => 'Welcome Specialist!', 'user' => auth()->user()]);
        } else {
            return response()->json(['message' => 'Invalid token'], 401);
        }
    }


    // Register a New User and Assign Role
    public function registerUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Create the user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Assign default role if no role is provided
        $role = $request->role ?? 'Specialist';
        $user->assignRole($role);

        // Generate a token for the newly registered user
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }



    // Login an Existing User
    public function loginUser(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            // Revoke all previous tokens
            $user->tokens()->delete();

            // Create a new token for the current session
            $token = $user->createToken('authToken')->plainTextToken;

            // Return user details along with the token
            return response()->json([
                'token' => $token,
                'user' => $user,
            ], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }



    public function users(){
        $users = User::forRoles(['Admin', 'Manager', 'Sale Operator'])->get();
        return response()->json($users);
    }

    public function me(){
        return auth()->user()->load('roles');
    }


    public function logoutUser()
    {
        $user = auth()->user();

        // Revoke the current token
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

}


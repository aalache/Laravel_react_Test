<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register Api - {name , email , password , password_confirmation}
    public function register(Request $request){

        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'string|in:admin,formateur'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role ?? User::ROLE_FORMATEUR, // default role
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'data' => $user,
        ],201);
    }

    // Login Api - { email , password}
    public function login(Request $request){

        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        // Generate token
        $token = $user->createToken("apiToken")->plainTextToken;

        // dd(auth()->user());die;
        
        AuditLogger::log('login', $user);

        return response()->json([
            'status'  => true,
            'message' => 'User logged in successfully',
            'token'   => $token,
        ]);
    }

    // Profile
    public function profile(Request $request){

        return response()->json([
            'status' => true,
            'message' => 'profile data',
            'data' => $request->user(),
        ]);
    }
    // Logout
    public function logout(Request $request){

        $request->user()->tokens()->delete();

        AuditLogger::log('logout',Auth::user());

        return response()->json([
            'status'=> true,
            'message' => 'user logged out successfully',
        ]);
    }
}

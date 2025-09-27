<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FormateurController extends Controller
{
    public function index()
    {
        $formateurs = User::where('role', User::ROLE_FORMATEUR)->get();

        return response()->json([
            'status' => true,
            'data'   => $formateurs,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $formateur = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => User::ROLE_FORMATEUR,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Formateur created successfully',
            'data'    => $formateur,
        ], 201);
    }

    public function show(User $user)
    {
        if ($user->role !== User::ROLE_FORMATEUR) {
            return response()->json([
                'status'  => false,
                'message' => 'Not a formateur',
            ], 400);
        }

        return response()->json([
            'status' => true,
            'data'   => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== User::ROLE_FORMATEUR) {
            return response()->json([
                'status'  => false,
                'message' => 'Not a formateur',
            ], 400);
        }

        $request->validate([
            'name'  => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only(['name', 'email']));

        return response()->json([
            'status'  => true,
            'message' => 'Formateur updated successfully',
            'data'    => $user,
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->role !== User::ROLE_FORMATEUR) {
            return response()->json([
                'status'  => false,
                'message' => 'Not a formateur',
            ], 400);
        }

        $user->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Formateur deleted successfully',
        ]);
    }
}

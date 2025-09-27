<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AuditLogger;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * List all admins.
     */
    public function index()
    {
        $admins = User::where('role',User::ROLE_ADMIN)->get();

        return Response()->json([
            'data' => $admins
        ],200);
    }

    /**
     * create new admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $newAdmin = User::create([
            'name' => $request->name,
            'email' =>  $request->email,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_ADMIN,
        ]);

        AuditLogger::log('created_admin',$newAdmin,null,$newAdmin);

        return response()->json([
            'status' => true,
            'message' => 'new admin added successfully',
            'data' => $newAdmin,
        ],201);

    }

    /**
     * Show a single admin
     */
    public function show(User $user)
    {
        //
        if($user->role !== User::ROLE_ADMIN){
            return response()->json([
                'status'=> false,
                'message'=> 'User is not an admin'
            ],400);
        }

        return response()->json([
            'status' => true,
            'message' => 'admin data',
            'data' => $user,
        ]);
    }

    /**
     * update admin
     */
    public function update(Request $request, User $user)
    {
        if($user->role !== User::ROLE_ADMIN){
            return response()->json([
                'status'=> false,
                'message'=> 'User is not an admin'
            ],400);
        }

        $oldData = $user->toArray();

        $request->validate([
            'name' => 'sometimes|string|max:50',
            'email' => 'sometimes|email|unique:users,email'.$user->id,
        ]);

        $user->update($request->only(['name','email']));

        AuditLogger::log('updated_admin',$user,$oldData,$user->toArray());

        return response()->json([
            'status' => true,
            'message' => 'Admin updated successfully',
            'data' => $user,
        ]);
    }

    /**
     * Delete admin
     */
    public function destroy(User $user)
    {
        if($user->role !== User::ROLE_ADMIN){
            return response()->json([
                'status'=> false,
                'message'=> 'User is not an admin'
            ],400);
        }

        $oldData = $user->toArray();

        $user->delete();

        AuditLogger::log('delete_admin',$user,$oldData,$user->toArray());

        return response()->json([
            'status' => true,
            'message' => 'Admin deleted successfully',
        ]);
    }
}

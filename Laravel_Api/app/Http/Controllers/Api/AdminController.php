<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AuditLogger;
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

        AuditLogger::log('created_admin',$newAdmin,null,$newAdmin->toArray());

        return response()->json([
            'status' => true,
            'message' => 'new admin added successfully',
            'data' => $newAdmin,
        ],201);

    }

    /**
     * Show a single admin
     */
    public function show(User $admin)
    {
        //
        if($admin->role !== User::ROLE_ADMIN){
            return response()->json([
                'status'=> false,
                'message'=> 'User is not an admin'
            ],400);
        }

        return response()->json([
            'status' => true,
            'message' => 'admin data',
            'data' => $admin,
        ]);
    }

    /**
     * update admin
     */
    public function update(Request $request, User $admin)
    {
        if($admin->role !== User::ROLE_ADMIN){
            return response()->json([
                'status'=> false,
                'message'=> 'User is not an admin'
            ],400);
        }

        $oldData = $admin->toArray();

        $request->validate([
            'name' => 'sometimes|string|max:50',
            'email' => 'sometimes|email|unique:users,email'.$admin->id,
        ]);

        $admin->update($request->only(['name','email']));

        AuditLogger::log('updated_admin',$admin,$oldData,$admin->toArray());

        return response()->json([
            'status' => true,
            'message' => 'Admin updated successfully',
            'data' => $admin,
        ]);
    }

    /**
     * Delete admin
     */
    public function destroy(User $admin)
    {
        if($admin->role !== User::ROLE_ADMIN){
            return response()->json([
                'status'=> false,
                'message'=> 'User is not an admin'
            ],400);
        }

        $oldData = $admin->toArray();

        $admin->delete();

        AuditLogger::log('delete_admin',$admin,$oldData,null);

        return response()->json([
            'status' => true,
            'message' => 'Admin deleted successfully',
        ]);
    }
}

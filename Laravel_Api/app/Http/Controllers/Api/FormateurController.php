<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AuditLogger;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            'password' => 'required|min:8',
        ]);

        $newFormateur = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => User::ROLE_FORMATEUR,
        ]);

        AuditLogger::log('create_formateur',$newFormateur,null,$newFormateur->toArray());

        return response()->json([
            'status'  => true,
            'message' => 'Formateur created successfully',
            'data'    => new UserResource($newFormateur),
        ], 201);
    }

    public function show(?User $formateur)
    {   
        if (!$formateur || $formateur->role !== User::ROLE_FORMATEUR) {
            return response()->json([
                'status'  => false,
                'message' => 'Formateur not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => new UserResource($formateur),
        ]);
        
    }


    public function update(Request $request, User $formateur)
    {
        if ($formateur->role !== User::ROLE_FORMATEUR) {
            return response()->json([
                'status'  => false,
                'message' => 'Not a formateur',
            ], 400);
        }

        $oldData = $formateur->toArray();

        $request->validate([
            'name'  => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $formateur->id,
        ]);


        $formateur->update($request->only(['name', 'email']));

        AuditLogger::log('update_formateur',$formateur,$oldData,$formateur->toArray());

        return response()->json([
            'status'  => true,
            'message' => 'Formateur updated successfully',
            'data'    => new UserResource($formateur),
        ]);
    }

    public function destroy(User $formateur)
    {
        if ($formateur->role !== User::ROLE_FORMATEUR) {
            return response()->json([
                'status'  => false,
                'message' => 'Not a formateur',
            ], 400);
        }

        $oldData = $formateur->toArray();

        $formateur->delete();

        AuditLogger::log("delete_formateur",$formateur,$oldData,$formateur->toArray());

        return response()->json([
            'status'  => true,
            'message' => 'Formateur deleted successfully',
        ]);
    }
}

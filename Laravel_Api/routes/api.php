<?php

use App\Http\Controllers\Api\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FormateurController;
use App\Http\Controllers\AuditLogController;

Route::controller(AuthController::class)->group(function(){
    Route::post('register','register');
    Route::post('login','login');
});

Route::middleware('auth:sanctum')->group(function(){
    Route::controller(AuthController::class)->group(function(){    
        Route::get('profile','profile');
        Route::get('logout','logout');
    });

    // admin routes (only admin can manage this)
    Route::middleware('role:admin')->group(function(){
        Route::apiResource('admins',AdminController::class);
        Route::get('/audit-logs',[AuditLogController::class,'index']);
    });

    // formateur routes ( formateur + admin can manage this)
    Route::middleware('role:admin,formateur')->group(function(){
        Route::apiResource('formateurs',FormateurController::class);
    });

});

<?php

use App\Models\Admin;
use App\Models\Formateur;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/api/admins',function(){
    return response()->json([
        'message' => 'liste des admins',
        'data' => Admin::all(),
    ]);
});

Route::get('/api/formateurs', function(){
    return response()->json([
        'message' => 'liste des formateurs',
        'data' => Formateur::all(),
    ]);
});
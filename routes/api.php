<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

// Public routes
Route::post('/register', [UserController::class, 'registerUser']);
Route::post('/login', [UserController::class, 'loginUser']);

// Protected routes (example routes with roles)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/admin', [UserController::class, 'adminAccess'])->middleware('role:Admin');
    Route::get('/manager', [UserController::class, 'managerAccess'])->middleware('role:Manager');
    Route::get('/sale-operator', [UserController::class, 'saleOperatorAccess'])->middleware('role:Sale Operator');
    // Route::get('/specialist', function(){
    //     return 1;
    // });
    Route::get('/specialist', [UserController::class, 'specialistAccess'])->middleware('role:Specialist');

    Route::get('/user', [UserController::class, 'user']);
    Route::post('/logout', [UserController::class, 'logoutUser']);
});

<?php

use App\Models\User;
use App\Models\Agreement;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\AgreementController;

// Public routes
Route::post('/register', [UserController::class, 'registerUser']);
Route::post('/login', [UserController::class, 'loginUser']);

// Protected routes (example routes with roles)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/admin', [UserController::class, 'adminAccess'])->middleware('role:Admin');
    Route::get('/manager', [UserController::class, 'managerAccess'])->middleware('role:Manager');
    Route::get('/sale-operator', [UserController::class, 'saleOperatorAccess'])->middleware('role:Sale Operator');
    Route::get('/specialist', [UserController::class, 'specialistAccess'])->middleware('role:Specialist');
    
    
    
    Route::get('/agreements', [AgreementController::class, 'index']); // All authenticated users can view agreements
    Route::post('/agreements', [AgreementController::class, 'store'])->middleware('role:Admin|Sale Operator'); // Create agreements
    Route::get('/agreements/{agreement}', [AgreementController::class, 'show']); // View an agreement
    Route::put('/agreements/{agreement}', [AgreementController::class, 'update'])->middleware(['role:Admin|Sale Operator']); // Update agreements
    Route::delete('/agreements/{agreement}', [AgreementController::class, 'destroy'])->middleware('role:Admin'); // Delete agreements





    Route::get('/users', [UserController::class, 'users']);
    Route::get('/me', [UserController::class, 'me']);
    Route::post('/logout', [UserController::class, 'logoutUser']);
});


// Route::get('gest', function(){
//     $agg = Agreement::create([
//         'created_by_id' => 2,
//         'responsible_user_id' => 1,
//         'flight_date' => '2025-01-15',
//         'duration_of_stay' => 10,
//         'client_name' => 'John Doe',
//         'client_relatives' => 'Jane Doe, Jack Doe',
//         'tariff_name' => 'Premium Package',
//         'room_type' => 'Double',
//         'transportation' => 'Bus',
//         'exchange_rate' => 3.5,
//         'total_price' => 1500.00,
//         'payment_paid' => 500.00,
//         'phone_numbers' => ['+998901234567', '+998909876543'],
//         'previous_agreement_taken_away' => true,
//         'comments' => 'Urgent client',
//     ]);

//     return response()->json(
//         $agg
//     );
// });
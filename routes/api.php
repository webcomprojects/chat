<?php

use App\Events\ChatEvent;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\OtpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/resend-verification-code', [AuthController::class, 'resendVerificationCode']);
Route::post('/send-verification-code', [AuthController::class, 'sendVerificationCode']);
Route::post('/verify-code', [AuthController::class, 'verifyCode']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/conversations/{conversationId}', [ChatController::class, 'index']);
    Route::post('/authentication', [AuthController::class, 'authentication']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/conversations', [ChatController::class, 'conversations']);
    Route::get('/conversation/{room_id}', [ChatController::class, 'conversation']);
    Route::post('/conversation/sendmessage', [ChatController::class, 'sendMessage']);
    Route::post('/conversation/create', [ChatController::class, 'createRoom']);
    Route::post('/conversation/join', [ChatController::class, 'joinRoom']);
    Route::post('/conversation/addroom', [ChatController::class, 'addRoom']);
    Route::post('/user/addcontact', [ChatController::class, 'addContact']);
    Route::get('/user/contacts', [ChatController::class, 'contacts']);

});

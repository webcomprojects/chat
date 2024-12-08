<?php

use App\Events\ChatEvent;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InfobillController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SendbillController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('admin.chat.index');
});



Auth::routes();


Route::middleware(['auth', 'loginbymobile'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('roles', RoleController::class);
    Route::get('users/profile/edit', [UserController::class, 'user_edit_profile'])->name('users.edit.profile');
    Route::put('users/profile/update', [UserController::class, 'user_update_profile'])->name('users.update.profile');
    Route::resource('users', UserController::class);
    Route::get('upload', [SendbillController::class, 'upload']);

    Route::post('/sendbills/{id}/change-status', [SendbillController::class, 'changeStatus'])->name('sendbills.changeStatus');
    Route::resource('sendbills', SendbillController::class);

    Route::get('infobills/bill/{id}', [InfobillController::class, 'bill'])->name('infobills.bill');
    Route::resource('infobills', InfobillController::class);
    Route::get('settings/edit', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');


    Route::get('/conversations', [ChatController::class, 'index']);
// Route::post('/conversations/{conversationId}/messages', [ChatController::class, 'sendMessage']);



});


Route::get('/otp/verifycodeform', [OtpController::class, 'verifycode_form'])->name('verify.form');
Route::post('/otp/verifycode', [OtpController::class, 'verifyCode'])->name('verify');
Route::get('/otp/login', [OtpController::class, 'login']);
Route::post('/otp/sendVerificationCode', [OtpController::class, 'sendVerificationCode'])->name('sendVerificationCode');
Route::post('/otp/resendCode', [OtpController::class, 'resendCode'])->name('resendCode');


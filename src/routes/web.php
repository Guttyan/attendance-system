<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/email/verify', function(){
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request){
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/', [AttendanceController::class, 'index']);
    Route::get('/attendance', [AttendanceController::class, 'attendance']);
    Route::get('/attendance/next_day', [AttendanceController::class, 'next_day']);
    Route::get('/attendance/before_day', [AttendanceController::class, 'before_day']);
    Route::post('/work_begin', [AttendanceController::class, 'work_begin']);
    Route::post('/work_finish', [AttendanceController::class, 'work_finish']);
    Route::post('/breaking_begin', [AttendanceController::class, 'breaking_begin']);
    Route::post('/breaking_finish', [AttendanceController::class, 'breaking_finish']);
    Route::get('/users_list', [AttendanceController::class, 'users_list']);
    Route::get('/users_list/user_record', [AttendanceController::class, 'user_record']);
});

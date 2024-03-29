<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserManagementController;

Route::get('/',[MainController::class, 'homepage'])->name('homepage');

Route::middleware('guest')->prefix('/user')->name('login.')->group(function() {
  Route::get('/login', [LoginController::class, "loginView"])->
    name('login-view');
    Route::any('/get-otp', [LoginController::class, "getOTP"])->
    name('get-otp');
    Route::post('/verify-otp', [LoginController::class, "verifyOTP"])->
    name('verify-otp');
});

Route::get('/unauthorized', [MainController::class, 'unauthorized'])->name('unauthorized');
Route::get('/login',[LoginController::class, "loginView"] )->name('login');
Route::get('/logout', [LoginController::class, "logout"])->
    name('logout');

Route::middleware('auth')->prefix('/dashboard')->name('dashboard.')->group(function() {
  Route::get('/main', [MainController::class, 'dashboard'])->name('main');
  
  Route::middleware('checkroles:admin')->prefix('/user-management')->name('user-management.')->group(function() {
    Route::get('/main', [UserManagementController::class, 'main'])->name('main');
    Route::post('/data', [UserManagementController::class, 'data'])->name('data');
    Route::post('/delete', [UserManagementController::class, 'delete'])->name('delete');
    Route::post('/ban', [UserManagementController::class, 'ban'])->name('ban');
    Route::post('/update-or-add', [UserManagementController::class, 'updateOrAddUser'])->name('update-or-add');
  });
});
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\EngineerController;
use App\Http\Controllers\ITODataController;

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

  Route::middleware('checkroles:admin,manager')->prefix('/service-management')->name('services.')->group(function() {
    Route::get('/main', [ServiceController::class, 'index'])->name('main');
    Route::post('/add', [ServiceController::class, 'store'])->name('store');
    Route::post('/data', [ServiceController::class, 'data'])->name('data');
    Route::post('/delete/{s_id}', [ServiceController::class, 'destroy'])->name('delete');
  });


  Route::middleware('checkroles:admin,manager')->prefix('/token-management')->name('token.')->group(function() {
    Route::get('/main', [TokenController::class, 'index'])->name('main');
    Route::post('/add', [TokenController::class, 'store'])->name('store');
    Route::post('/data', [TokenController::class, 'data'])->name('data');
    Route::post('/check-user-exists', [TokenController::class, 'isExist'])->name('check-user-exists');
  });

  Route::middleware('checkroles:admin,engineer')->prefix('/engineer')->name('engineer.')->group(function() {
    Route::get('/main', [EngineerController::class, 'index'])->name('main');
  });

  Route::middleware('checkroles:admin,supervisor')->prefix('/iot-data')->name('iot-data.')->group(function() {
    Route::get('/main', [ITODataController::class, 'index'])->name('main');
    Route::post('/chart-data', [ITODataController::class, 'chartData'])->name('chart-data');
  });

});
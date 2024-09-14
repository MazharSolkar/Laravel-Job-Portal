<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/account/register', [AccountController::class, 'registration'])->name('account.register');
Route::post('/account/process-register', [AccountController::class, 'processRegistration'])->name('account.processRegistration');

Route::get('/account/login', [AccountController::class, 'login'])->name('account.login');
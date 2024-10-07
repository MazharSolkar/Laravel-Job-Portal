<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\JobsController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs');
Route::get('/jobs/detail/{id}', [JobsController::class, 'detail'])->name('jobDetail');

Route::group(['prefix'=>'account'], function() {
    // Guest Route
    Route::middleware(['guestUser'])->group(function() {
        Route::get('/register', [AccountController::class, 'registration'])->name('account.register');
        Route::post('/process-register', [AccountController::class, 'processRegistration'])->name('account.processRegistration');
        
        Route::get('/login', [AccountController::class, 'login'])->name('account.login');
        Route::post('/process-login', [AccountController::class, 'processLogin'])->name('account.processLogin');
    });

    // Authenticated Routes
    Route::middleware(['authUser'])->group(function() {
        Route::get('/profile',[AccountController::class, 'profile'])->name('account.profile');
        Route::put('/update-profile',[AccountController::class, 'updateProfile'])->name('account.updateProfile');
        Route::put('/update-profile-pic',[AccountController::class, 'updateProfilePic'])->name('account.updateProfilePic');

        Route::get('/logout',[AccountController::class, 'logout'])->name('account.logout');

        Route::get('/create-job',[AccountController::class, 'createJob'])->name('account.createJob');
        Route::post('/post-job',[AccountController::class, 'postJob'])->name('account.postJob');
        Route::get('/create-job',[AccountController::class, 'createJob'])->name('account.createJob');

        Route::get('/my-jobs',[AccountController::class, 'myJobs'])->name('account.myJobs');
        Route::get('/my-jobs/edit/{job}',[AccountController::class, 'editJob'])->name('account.editJob');
        Route::put('/my-jobs/update/{job}',[AccountController::class, 'updateJob'])->name('account.updateJob');
        Route::delete('/my-jobs/delete/{job}',[AccountController::class, 'deleteJob'])->name('account.deleteJob');
    });
});
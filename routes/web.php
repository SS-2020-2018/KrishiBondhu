<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FarmerProfileController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/help', function () {
        return view('help');
    })->name('help');
});


Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':farmer'])->group(function () {
    Route::get('/profile/farmer', [FarmerProfileController::class, 'edit'])->name('profile.farmer');
    Route::post('/profile/farmer', [FarmerProfileController::class, 'update'])->name('profile.farmer.update');
});
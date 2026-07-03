<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FarmerProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AgriUtilityController;
use App\Http\Controllers\CommunicationController;

Route::middleware(['auth'])->group(function () {
  
    Route::post('/marketplace/{id}/review', [CommunicationController::class, 'storeReview'])->name('review.store');

    Route::get('/chat/{receiver_id}', [CommunicationController::class, 'chatRoom'])->name('chat.room');
    Route::get('/chat/{receiver_id}/fetch', [CommunicationController::class, 'fetchMessages'])->name('chat.fetch');
    Route::post('/chat/{receiver_id}/send', [CommunicationController::class, 'sendMessage'])->name('chat.send');

    
    Route::post('/notifications/clear', [CommunicationController::class, 'clearNotifications'])->name('notifications.clear');
});

Route::get('/', function () { return view('welcome'); })->name('home');
Route::get('/services', function () { return view('services'); })->name('services');
Route::get('/contact', function () { return view('contact'); })->name('contact');


Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/help', function () { return view('help'); })->name('help');
    Route::get('/dashboard', [FarmerProfileController::class, 'edit'])->name('dashboard');
    Route::post('/dashboard', [FarmerProfileController::class, 'update'])->name('dashboard.update');

    Route::get('/marketplace', [ProductController::class, 'index'])->name('marketplace.index');
    Route::get('/marketplace/create', [ProductController::class, 'create'])->name('marketplace.create');
    Route::post('/marketplace', [ProductController::class, 'store'])->name('marketplace.store');
    Route::get('/marketplace/{id}', [ProductController::class, 'show'])->name('marketplace.show');
    Route::get('/my-listings', [ProductController::class, 'myListings'])->name('marketplace.mine');

  
    Route::get('/agri-utilities', [AgriUtilityController::class, 'index'])->name('utilities.index');
    Route::post('/agri-utilities/pest-report', [AgriUtilityController::class, 'storePestReport'])->name('utilities.pest');
    Route::post('/agri-utilities/seed-calc', [AgriUtilityController::class, 'calculateSeed'])->name('utilities.seed');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/farmer', [FarmerProfileController::class, 'edit'])->name('profile.farmer');
    Route::post('/profile/farmer', [FarmerProfileController::class, 'update'])->name('profile.farmer.update');
});
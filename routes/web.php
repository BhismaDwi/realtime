<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware('auth')->group(function () {
    Route::get('chat', function () {
        return view('chat');
    })->name('chat');

    Route::get('private', function () {
        return view('private');
    })->name('private');
}); 

require __DIR__.'/auth.php';

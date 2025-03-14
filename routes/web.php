<?php

use Illuminate\Support\Facades\Route;

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
    
Route::view('/about','about');
Route::view('/privacy','privacy');
Route::view('/terms','terms');
Route::view('/contact','contact');

require __DIR__.'/google_sheet_post.php';
require __DIR__.'/pen_data.php';
require __DIR__.'/fatwa.php';
require __DIR__.'/admin.php';
require __DIR__.'/auth.php';


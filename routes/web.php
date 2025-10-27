<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::view('members', 'members.index')
    ->middleware(['auth'])
    ->name('members.index');

Route::view('members/{member}', 'members.show')
    ->middleware(['auth'])
    ->name('members.show');

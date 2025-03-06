<?php

use App\Livewire\Chat;
use App\Livewire\Users;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Users::class)->name('dashboard');
    Route::get('/chat',Chat::class)->name('chat');
});
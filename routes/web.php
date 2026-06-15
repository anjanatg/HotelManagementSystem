<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManagementController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
});
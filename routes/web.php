<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('room', RoomController::class);
    Route::get('/room/{room}/join', [RoomController::class, 'join'])->name('room.join');
    Route::get('/room/{room}/leave', [RoomController::class, 'leave'])->name('room.leave');
    Route::post('/room/{room}/message', [MessageController::class, 'send'])->name('message.send');

    Route::get('/message', [MessageController::class, 'index'])->name('message.index');
});

require __DIR__.'/auth.php';

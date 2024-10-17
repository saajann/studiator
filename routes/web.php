<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PomodoroController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Models\Pomodoro;

Route::get('/pomodoro', function () {
    $pomodoros = Pomodoro::where('user_id', Auth::id())->orderBy('completed_at', 'desc')->get();
    return view('pomodoro', compact('pomodoros'));
})->middleware(['auth', 'verified'])->name('pomodoro');

Route::post('/save-pomodoro', [PomodoroController::class, 'store'])->name('save-pomodoro');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

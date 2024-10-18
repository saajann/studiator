<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PomodoroController;
use App\Http\Controllers\FlashcardController;
use App\Models\Pomodoro;
use App\Models\Flashcard;

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('/pomodoro', [PomodoroController::class, 'index'])->middleware(['auth', 'verified'])->name('pomodoro.index');

Route::post('/pomodoro', [PomodoroController::class, 'store'])->name('pomodoro.store');

Route::get('/flashcards', [FlashcardController::class, 'index'])->middleware(['auth', 'verified'])->name('flashcards.index');

Route::post('/flashcards', [FlashcardController::class, 'store'])->name('flashcards.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

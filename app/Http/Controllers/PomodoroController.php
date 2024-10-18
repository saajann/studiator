<?php

namespace App\Http\Controllers;

use Carbon\Carbon; // Assicurati di importare Carbon
use App\Models\Pomodoro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PomodoroController extends Controller
{
    public function index()
    {
        $pomodoros = Pomodoro::where('user_id', Auth::id())->orderBy('completed_at', 'desc')->get();
        return view('pomodoro', compact('pomodoros'));
    }
    
    public function store(Request $request)
    {
        // Validazione
        $request->validate([
            'duration' => 'required|integer',
        ]);

        // Creazione del pomodoro
        Pomodoro::create([
            'user_id' => auth()->id(), // Imposta l'user_id dell'utente autenticato
            'duration' => $request->input('duration'),
            'completed_at' => Carbon::now(), // Usa Carbon per la data attuale
        ]);

        return redirect()->route('pomodoro.index')->with('success', 'Timer Pomodoro saved successfully!');
    }
}

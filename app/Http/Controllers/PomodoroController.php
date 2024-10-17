<?php

namespace App\Http\Controllers;

use Carbon\Carbon; // Assicurati di importare Carbon
use App\Models\Pomodoro;
use Illuminate\Http\Request;

class PomodoroController extends Controller
{
    

public function store(Request $request)
{
    // Validazione
    $request->validate([
        'duration' => 'required|integer',
    ]);

    // Creazione del pomodoro
    $pomodoro = new Pomodoro();
    $pomodoro->user_id = auth()->id(); // Imposta l'user_id dell'utente autenticato
    $pomodoro->duration = $request->duration;
    $pomodoro->completed_at = Carbon::now(); // Usa Carbon per la data attuale
    $pomodoro->save();

    // return response()->json(['message' => 'Pomodoro salvato con successo']);
}
}

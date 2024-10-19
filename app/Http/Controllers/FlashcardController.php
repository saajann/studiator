<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlashcardController extends Controller
{
    // Metodo per visualizzare le flashcard
    public function index(Request $request)
    {
        // Inizia la query per l'utente attuale
        $query = Flashcard::where('user_id', Auth::id());

        // Filtra per subject se presente
        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }

        // Filtra per topic se presente
        if ($request->filled('topic')) {
            $query->where('topic', $request->topic);
        }

        // Ordina le flashcard per data di creazione (decrescente)
        $flashcards = $query->orderBy('created_at', 'desc')->get();

        // Ottieni tutti i subject e topic disponibili per i filtri
        $subjects = Flashcard::where('user_id', Auth::id())->select('subject')->distinct()->pluck('subject');
        $topics = Flashcard::where('user_id', Auth::id())->select('topic')->distinct()->pluck('topic');

        return view('flashcards', compact('flashcards', 'subjects', 'topics'));
    }


    // Metodo per salvare una nuova flashcard
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:255',
        ]);

        Flashcard::create([
            'user_id' => Auth::id(),
            'subject' => $request->input('subject'),
            'topic' => $request->input('topic'),
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
        ]);

        return redirect()->route('flashcards.index')->with('success', 'Flashcard created successfully !');
    }

    public function destroy($id)
    {
        // Trova la flashcard per ID e la elimina
        $flashcard = Flashcard::findOrFail($id);
        $flashcard->delete();

        // Reindirizza alla pagina delle flashcard con un messaggio di successo
        return redirect()->route('flashcards.index')->with('success', 'Flashcard created successfully !');
    }
}

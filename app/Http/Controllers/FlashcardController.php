<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlashcardController extends Controller
{
    // Metodo per visualizzare le flashcard
    public function index()
    {
        $flashcards = Flashcard::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('flashcards', compact('flashcards'));
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
}

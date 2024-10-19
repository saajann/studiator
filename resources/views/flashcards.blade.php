<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Flashcards') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                        <form method="GET" action="{{ route('flashcards.index') }}" class="mb-4">
                            <div class="flex space-x-4">
                                <div>
                                    <label for="subject" class="block text-sm font-medium text-gray-700">Materia</label>
                                    <select name="subject" id="subject" class="form-select mt-1 block w-full">
                                        <option value="">Tutte le materie</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject }}" {{ request('subject') == $subject ? 'selected' : '' }}>
                                                {{ $subject }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                        
                                <div>
                                    <label for="topic" class="block text-sm font-medium text-gray-700">Argomento</label>
                                    <select name="topic" id="topic" class="form-select mt-1 block w-full">
                                        <option value="">Tutti gli argomenti</option>
                                        @foreach($topics as $topic)
                                            <option value="{{ $topic }}" {{ request('topic') == $topic ? 'selected' : '' }}>
                                                {{ $topic }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                        
                                <div class="flex items-end">
                                    <button type="submit" class="bg-blue-500 p-2 rounded">Filtra</button>
                                </div>
                            </div>
                        </form>
                    <!-- Sezione per visualizzare le flashcard -->
                    @if($flashcards->isEmpty())
                        <p>Non hai ancora creato nessuna flashcard.</p>
                    @else

                        
                    

                        <div class="flex justify-end mt-4">
                            <!-- Pulsante per eliminare la flashcard -->
                            <form action="{{ route('flashcards.destroy', $flashcards[0]->id) }}" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questa flashcard?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 p-2 rounded mt-4">Elimina</button>
                            </form>
                            
                        </div>
                            
                        <div id="flashcard-container">
                            <span id="flashcard-subject">Subject: {{ $flashcards[0]->subject }}</span>
                            <br>
                            <span id="flashcard-topic">Topic: {{ $flashcards[0]->topic }}</span>
                            <div id="flashcard" class="flashcard p-4 border rounded-lg cursor-pointer text-center" onclick="toggleAnswer()">
                                <span id="flashcard-content">{{ $flashcards[0]->question }}</span>
                            </div>
                        </div>
        
                        <div class="flex justify-between mt-4">
                            <button id="prev-btn" class="bg-gray-300 p-2 rounded" onclick="prevFlashcard()" disabled>Indietro</button>
                            <button id="next-btn" class="bg-gray-300 p-2 rounded" onclick="nextFlashcard()">Avanti</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>        
        <br>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-4">Crea una nuova flashcard</h3>
                        <form action="{{ route('flashcards.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="subject" class="block text-sm font-medium text-gray-700">Materia</label>
                                <input type="text" id="subject" name="subject" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="mb-4">
                                <label for="topic" class="block text-sm font-medium text-gray-700">Argomento</label>
                                <input type="text" id="topic" name="topic" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="mb-4">
                                <label for="question" class="block text-sm font-medium text-gray-700">Domanda</label>
                                <input type="text" id="question" name="question" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="mb-4">
                                <label for="answer" class="block text-sm font-medium text-gray-700">Risposta</label>
                                <input type="text" id="answer" name="answer" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="bg-blue-500 py-2 px-4 rounded">Crea Flashcard</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!$flashcards->isEmpty())
        <script>
            let flashcards = @json($flashcards); // Converti i dati delle flashcard in un array JavaScript
            let currentIndex = 0;
            let showingQuestion = true;

            function toggleAnswer() {
                let content = document.getElementById('flashcard-content');
                if (showingQuestion) {
                    content.textContent = flashcards[currentIndex].answer;
                } else {
                    content.textContent = flashcards[currentIndex].question;
                }
                showingQuestion = !showingQuestion;
            }

            function nextFlashcard() {
                if (currentIndex < flashcards.length - 1) {
                    currentIndex++;
                    updateFlashcard();
                }
            }

            function prevFlashcard() {
                if (currentIndex > 0) {
                    currentIndex--;
                    updateFlashcard();
                }
            }

            function updateFlashcard() {
                let content = document.getElementById('flashcard-content');
                let subject = document.getElementById('flashcard-subject');
                let topic = document.getElementById('flashcard-topic');
                subject.textContent = 'Subject: ' + flashcards[currentIndex].subject;
                topic.textContent = 'Topic: ' + flashcards[currentIndex].topic;
                content.textContent = flashcards[currentIndex].question;
                showingQuestion = true; // Ritorna alla domanda
                document.getElementById('prev-btn').disabled = currentIndex === 0;
                document.getElementById('next-btn').disabled = currentIndex === flashcards.length - 1;
            }
        </script>
    @endif

</x-app-layout>

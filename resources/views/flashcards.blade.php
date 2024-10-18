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

                    <!-- Sezione per visualizzare le flashcard -->
                    @if($flashcards->isEmpty())
                        <p>Non hai ancora creato nessuna flashcard.</p>
                    @else
                        <div id="flashcard-container">
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
                content.textContent = flashcards[currentIndex].question;
                showingQuestion = true; // Ritorna alla domanda
                document.getElementById('prev-btn').disabled = currentIndex === 0;
                document.getElementById('next-btn').disabled = currentIndex === flashcards.length - 1;
            }
        </script>
    @endif

</x-app-layout>

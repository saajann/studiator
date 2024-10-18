<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pomodoro') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <h1 class="text-2xl mb-4">Pomodoro Timer</h1>

                    <!-- Input per impostare la durata del timer -->
                    <label for="duration" class="block mb-2">Durata (in minuti):</label>
                    <input id="duration" type="number" min="1" value="25" class="mb-4 p-2 border rounded w-20 text-center">

                    
                    <!-- Timer display -->
                    <div id="timer" class="text-4xl mb-4">25:00</div>
                    
                    <!-- Pulsanti di controllo -->
                    <button id="start" class="py-2 px-4 rounded hover:bg-green-600 transition">Inizia</button>
                    <button id="pause" class="py-2 px-4 rounded hover:bg-blue-600 transition">Pausa</button>
                    <button id="reset" class="py-2 px-4 rounded hover:bg-yellow-600 transition">Ripristina</button>
                    
                    <!-- Allerta alla fine del timer 
                    <audio id="alarm" src="/path/to/sound.mp3"></audio>-->

                    <form action="{{ route('pomodoro.store') }}" method="POST">
                        @csrf
                        <label for="duration">Durata (in minuti):</label>
                        <input type="number" id="duration" name="duration" min="1" required>
                        
                        <button type="submit">Salva</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabella Pomodori Completati -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-xl mb-4">Pomodori Completati</h2>

                    @if ($pomodoros->isEmpty())
                        <p>Non hai completato nessun pomodoro.</p>
                    @else
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2">Durata (minuti)</th>
                                    <th class="py-2">Completato il</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pomodoros as $pomodoro)
                                    <tr>
                                        <td class="py-2 text-center">{{ $pomodoro->duration }}</td>
                                        <td class="py-2 text-center">{{ $pomodoro->completed_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        let timer;
let isRunning = false;
let isPaused = false;
let timeLeft = 25 * 60; // 25 minuti in secondi
let completedPomodoros = 0;

function updateTimerDisplay() {
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    document.getElementById('timer').textContent = 
        String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
}

function resetTimer() {
    clearInterval(timer);
    isRunning = false;
    isPaused = false;
    const duration = parseInt(document.getElementById('duration').value);
    timeLeft = duration * 60; // Ripristina alla durata impostata dall'utente
    updateTimerDisplay();
    document.getElementById('pause').textContent = "Pausa"; // Resetta il pulsante di pausa
}

function startTimer() {
    if (!isRunning) {
        isRunning = true;
        timer = setInterval(() => {
            if (timeLeft > 0 && !isPaused) {
                timeLeft--;
                updateTimerDisplay();
            } else if (timeLeft === 0) {
                clearInterval(timer);
                isRunning = false;
                completedPomodoros++;
                
                alert("Tempo scaduto!"); // Mostra l'alert

                // Salva il Pomodoro nel database
                savePomodoro(document.getElementById('duration').value);

                // Automaticamente resetta il timer a 5 minuti per la pausa
                timeLeft = 5 * 60; // 5 minuti di pausa
                updateTimerDisplay();
            }
        }, 1000);
    }
}

function savePomodoro(duration) {
    alert("dentro fun save pomodoro!"); // Mostra l'alert
    fetch('/pomodoro.store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            duration: duration,
            completed_at: new Date().toISOString() // Aggiungi questa riga
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Errore nella risposta: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        console.log('Pomodoro salvato con successo:', data);
        alert('Pomodoro salvato con successo!');
    })
    .catch(error => {
        console.error('Errore nel salvataggio:', error);
        alert('Errore nel salvataggio del pomodoro: ' + error.message);
    });
}

document.getElementById('start').addEventListener('click', () => {
    const duration = parseInt(document.getElementById('duration').value);
    timeLeft = duration * 60; // Imposta la durata in secondi
    updateTimerDisplay();
    startTimer();
});

document.getElementById('pause').addEventListener('click', () => {
    isPaused = !isPaused;
    document.getElementById('pause').textContent = isPaused ? "Riprendi" : "Pausa";
});

document.getElementById('reset').addEventListener('click', resetTimer);

updateTimerDisplay();

    </script>    
</x-app-layout>

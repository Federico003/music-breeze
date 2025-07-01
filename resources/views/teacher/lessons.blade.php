<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">
            {{ __('Lista Lezioni') }}
        </h2>
    </x-slot>

    <div class="py-6 dark:bg-gray-900">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 dark:bg-gray-900">
            <div class="bg-white shadow-xl sm:rounded-lg p-0 m-0 dark:bg-gray-200">

                <!-- Lista -->
                <div id="list-container" class="mt-4 bg-orange-100 dark:bg-gray-900">
                    <div class="overflow-hidden rounded-2xl shadow ring-1 ring-black ring-opacity-5">
                        <div class="overflow-x-auto rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
                                <thead
                                    class="bg-orange-400 dark:bg-gray-800 text-black dark:text-gray-300 uppercase tracking-wider">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold sortable">Studente <span
                                                class="sort-icon"></span></th>
                                        <th class="px-4 py-3 font-semibold sortable">Corso <span
                                                class="sort-icon"></span></th>
                                        <th class="px-4 py-3 font-semibold sortable">Data <span
                                                class="sort-icon"></span></th>
                                        <th class="px-4 py-3 font-semibold sortable">Ora Inizio <span
                                                class="sort-icon"></span></th>
                                        <th class="px-4 py-3 font-semibold sortable">Ora Fine <span
                                                class="sort-icon"></span></th>
                                        <th class="px-4 py-3 font-semibold">Azioni</th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-orange-200 dark:bg-gray-900 divide-y divide-orange-300 dark:divide-gray-700 text-black dark:text-white"
                                    id="lessons-table-body">
                                    @foreach ($events as $event)
                                        <tr data-id="{{ $event['id'] }}">
                                            <td class="px-4 py-3 whitespace-nowrap student-full-name">
                                                {{ $event['student_full_name'] ?? '-' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap course-name">
                                                {{ $event['course_name'] ?? '-' }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap day-cell">
                                                {{ \Carbon\Carbon::parse($event['day'])->format('d-m-Y') }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap start-cell">
                                                {{ \Carbon\Carbon::parse($event['time'])->format('H:i') }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap end-cell">
                                                @php
                                                    $start = \Carbon\Carbon::parse($event['time']);
                                                    $end = $start->copy()->addMinutes($event['duration']);
                                                @endphp
                                                {{ $end->format('H:i') }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap actions-cell">
                                                <div class="flex items-center space-x-3">
                                                    <button type="button"
                                                        class="edit-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-600 p-2 m-2"
                                                        title="Modifica">
                                                        <x-heroicon-s-pencil class="w-5 h-5" />
                                                    </button>
                                                    <form
                                                        action="{{ route('insegnante.destroy-lessons', $event['id']) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Sei sicuro di voler eliminare questa lezione?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Elimina"
                                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-600 p-2 m-2">
                                                            <x-heroicon-s-trash class="w-5 h-5" />
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('table');

            // ----------- ORDINA TABELLA -----------------
            const headers = table.querySelectorAll('thead th.sortable');
            headers.forEach((header, index) => {
                header.style.cursor = 'pointer';
                header.addEventListener('click', () => {
                    const currentIsAscending = header.classList.contains('asc');
                    // Rimuovo classi da tutte le intestazioni
                    headers.forEach(h => h.classList.remove('asc', 'desc'));
                    // Imposto classe per ordinamento
                    header.classList.toggle('asc', !currentIsAscending);
                    header.classList.toggle('desc', currentIsAscending);
                    sortTableByColumn(table, index, !currentIsAscending);
                });
            });

            function sortTableByColumn(table, column, asc = true) {
                const dirModifier = asc ? 1 : -1;
                const tBody = table.tBodies[0];
                const rows = Array.from(tBody.querySelectorAll('tr'));

                // Funzione di confronto per tipi diversi di dati (data, ora, stringa)
                const compare = (a, b) => {
                    let aText = a.children[column].textContent.trim();
                    let bText = b.children[column].textContent.trim();

                    // Prova a capire se è data o ora e confronta di conseguenza
                    const dateRegex = /^\d{4}-\d{2}-\d{2}$/; // YYYY-MM-DD
                    const timeRegex = /^\d{2}:\d{2}(:\d{2})?$/; // HH:mm o HH:mm:ss

                    if (dateRegex.test(aText) && dateRegex.test(bText)) {
                        return (new Date(aText) - new Date(bText)) * dirModifier;
                    } else if (timeRegex.test(aText) && timeRegex.test(bText)) {
                        // Converte in minuti per confrontare
                        const toMinutes = str => {
                            const parts = str.split(':').map(Number);
                            return parts[0] * 60 + parts[1];
                        };
                        return (toMinutes(aText) - toMinutes(bText)) * dirModifier;
                    } else {
                        // Confronto stringhe case insensitive
                        return aText.localeCompare(bText) * dirModifier;
                    }
                };

                // Ordina righe
                const sortedRows = rows.sort(compare);

                // Rimuovi righe esistenti
                while (tBody.firstChild) {
                    tBody.removeChild(tBody.firstChild);
                }

                // Aggiungi righe ordinate
                tBody.append(...sortedRows);
            }

            // -------------------------------------------


            table.addEventListener('click', function(event) {
                const target = event.target.closest('button');
                if (!target) return;

                const row = target.closest('tr');
                if (!row) return;

                if (target.classList.contains('edit-btn')) {
                    enterEditMode(row);
                } else if (target.classList.contains('save-btn')) {
                    saveEdit(row);
                } else if (target.classList.contains('cancel-btn')) {
                    exitEditMode(row);
                }
            });

            function enterEditMode(row) {
    // Cambia header "Ora Fine" in "Durata (minuti)"
    const endTh = document.querySelector('thead th:nth-child(5)');
    endTh.textContent = 'Durata (minuti)';

    // Funzione di conversione data
    function formatDateForInput(dateStr) {
        const parts = dateStr.split('-');
        if(parts.length !== 3) return '';
        const [dd, mm, yyyy] = parts;
        return `${yyyy}-${mm.padStart(2, '0')}-${dd.padStart(2, '0')}`;
    }

    // Estrai valori correnti
    const dayCell = row.children[2];
    const startCell = row.children[3];
    const endCell = row.children[4];
    const actionsCell = row.children[5];

    const currentDay = formatDateForInput(dayCell.textContent.trim()); // formato YYYY-MM-DD per input date
    const currentStart = startCell.textContent.trim(); // HH:mm
    const currentEnd = endCell.textContent.trim(); // HH:mm

    // Calcolo durata in minuti
    const startParts = currentStart.split(':').map(Number);
    const endParts = currentEnd.split(':').map(Number);
    const startMinutes = startParts[0] * 60 + startParts[1];
    const endMinutes = endParts[0] * 60 + endParts[1];
    const duration = endMinutes - startMinutes;

    // Sostituisci celle con input
    dayCell.innerHTML = `<input type="date" class="edit-day dark:text-black" value="${currentDay}" />`;
    startCell.innerHTML = `<input type="time" class="edit-time-start dark:text-black" value="${currentStart.slice(0,5)}" />`;
    endCell.innerHTML = `<input type="number" min="1" class="edit-duration dark:text-black" value="${duration}" />`;

    // Cambia azioni: mostra salva e annulla
    actionsCell.innerHTML = `
        <button type="button" class="save-btn px-2 py-1 bg-green-600 text-white rounded" title="Salva">Salva</button>
        <button type="button" class="cancel-btn px-2 py-1 bg-gray-500 text-white rounded ml-2" title="Annulla">Annulla</button>
    `;
}


            function exitEditMode(row) {
                // Per semplicità ricarica la pagina, così torna alla visualizzazione normale
                window.location.reload();
            }

            function saveEdit(row) {
                const lessonId = row.dataset.id;
                const dayInput = row.querySelector('.edit-day');
                const timeStartInput = row.querySelector('.edit-time-start');
                const durationInput = row.querySelector('.edit-duration');

                const day = dayInput.value; // 'YYYY-MM-DD'
                const timeStart = timeStartInput.value; // 'HH:MM'
                const duration = parseInt(durationInput.value);

                if (!day || !timeStart || !duration || duration <= 0) {
                    alert('Inserisci una data, ora di inizio e durata validi');
                    return;
                }

                fetch(`/insegnante/update-lessons/${lessonId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            day,
                            time: timeStart + ':00',
                            duration
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Errore durante l\'aggiornamento');
                        return response.json();
                    })
                    .then(data => {
                        alert('Lezione aggiornata con successo');
                        window.location.reload();
                    })
                    .catch(err => {
                        alert(err.message);
                    });
            }
        });
    </script>

    <style>
        th.sortable {
            position: relative;
            user-select: none;
        }

        .sort-icon {
            font-size: 0.75em;
            margin-left: 4px;
        }

        th.sortable.asc .sort-icon::after {
            content: "▲";
            color: #000;
        }

        th.sortable.desc .sort-icon::after {
            content: "▼";
            color: #000;
        }
    </style>
</x-app-layout>

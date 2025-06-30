<x-app-layout>


    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Calendario Lezioni') }}
        </h2>
    </x-slot>

    <div class="py-6 dark:bg-grey-600">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 dark:bg-grey-600">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 dark:bg-gray-200">

                <!-- Toggle tra calendario e lista -->
                <div class="mb-4">
                    <button id="btn-calendar" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">Vista
                        Calendario</button>
                    <button id="btn-list" class="bg-gray-500 text-white px-4 py-2 rounded">Vista Lista</button>
                </div>

                <!-- Calendario -->
                <div id="calendar-container" class="w-full h-[80vh]">
                    <div id="calendar" class="h-full"></div>
                </div>

                <!-- Lista -->
                <div id="list-container" class="hidden mt-4">
                    <table class="min-w-full divide-y divide-gray-200 dark:bg-grey-600">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer sortable"
                                    data-sort="student">
                                    Studente <i class="fa-solid fa-sort ml-1" data-sort="student"></i>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer sortable"
                                    data-sort="teacher">
                                    Insegnante <i class="fa-solid fa-sort ml-1" data-sort="teacher"></i>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer sortable"
                                    data-sort="course">
                                    Corso <i class="fa-solid fa-sort ml-1" data-sort="course"></i>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer sortable"
                                    data-sort="date">
                                    Data <i class="fa-solid fa-sort ml-1" data-sort="data"></i>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-s font-medium text-gray-500 uppercase tracking-wider">
                                    Ora Inizio
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-s font-medium text-gray-500 uppercase tracking-wider">
                                    Ora Fine
                                </th>

                                <th class="px-6 py-3 text-left text-s font-medium text-gray-500 uppercase tracking-wider">
                                    Azioni
                                </th>
                            </tr>
                        </thead>


                        <tbody class="bg-white divide-y divide-gray-200 ">
                            @foreach ($events as $event)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $event['student_full_name'] ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $event['teacher_full_name'] ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $event['course_name'] ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($event['start'])->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($event['start'])->format('H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($event['end'])->format('H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('insegnante.destroy-lessons', $event['id']) }}" method="POST"
                                            onsubmit="return confirm('Sei sicuro di voler eliminare questa lezione?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:text-red-700">Elimina</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>


                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal dettagli evento -->
    <div id="eventModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
            <button id="closeModal"
                class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl font-bold">&times;</button>
            <h3 class="text-xl font-semibold mb-4" id="modalTitle"></h3>
            <p><strong>Studente:</strong> <span id="modalStudent"></span></p>
            <p><strong>Insegnante:</strong> <span id="modalTeacher"></span></p>
            <p><strong>Corso:</strong> <span id="modalCourse"></span></p>
            <p><strong>Data:</strong> <span id="modalDate"></span></p>
            <p><strong>Ora Inizio:</strong> <span id="modalStart"></span></p>
            <p><strong>Ora Fine:</strong> <span id="modalEnd"></span></p>
        </div>
    </div>

    <!-- FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales-all.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const events = @json($events);

            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'it',
                firstDay: 1,
                height: '100%',
                expandRows: true,
                slotMinTime: '06:00',
                slotMaxTime: '22:00',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                buttonText: {
                    today: 'Oggi',
                    month: 'Mese',
                    week: 'Settimana',
                    day: 'Giorno',
                    list: 'Elenco'
                },
                initialView: 'dayGridMonth',
                navLinks: true,
                editable: false,
                selectable: false,
                nowIndicator: true,
                dayMaxEvents: true,
                timeZone: 'local',
                slotLabelFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                events: events,

                // Aggiunta gestione click su evento
                eventClick: function(info) {
                    const event = info.event;

                    // Seleziono il modal e i suoi elementi
                    const modal = document.getElementById('eventModal');
                    const modalTitle = document.getElementById('modalTitle');
                    const modalStudent = document.getElementById('modalStudent');
                    const modalTeacher = document.getElementById('modalTeacher');

                    const modalCourse = document.getElementById('modalCourse');
                    const modalDate = document.getElementById('modalDate');
                    const modalStart = document.getElementById('modalStart');
                    const modalEnd = document.getElementById('modalEnd');

                    // Popolo i dati nel modal
                    modalTitle.textContent = event.title || 'Dettagli lezione';
                    modalStudent.textContent = event.extendedProps.student_full_name || 'N/A';
                    modalTeacher.textContent = event.extendedProps.teacher_full_name || 'N/A';
                    modalCourse.textContent = event.extendedProps.course_name || 'N/A';

                    const startDate = event.start;
                    const endDate = event.end;

                    modalDate.textContent = startDate ? startDate.toLocaleDateString('it-IT') : 'N/A';
                    modalStart.textContent = startDate ? startDate.toLocaleTimeString('it-IT', {
                        hour: '2-digit',
                        minute: '2-digit'
                    }) : 'N/A';
                    modalEnd.textContent = endDate ? endDate.toLocaleTimeString('it-IT', {
                        hour: '2-digit',
                        minute: '2-digit'
                    }) : 'N/A';

                    // Mostro il modal
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                }
            });

            calendar.render();

            // Toggle visibilità calendario/lista
            const calendarContainer = document.getElementById('calendar-container');
            const listContainer = document.getElementById('list-container');
            const btnCalendar = document.getElementById('btn-calendar');
            const btnList = document.getElementById('btn-list');

            btnCalendar.addEventListener('click', () => {
                calendarContainer.classList.remove('hidden');
                listContainer.classList.add('hidden');
            });

            btnList.addEventListener('click', () => {
                calendarContainer.classList.add('hidden');
                listContainer.classList.remove('hidden');
            });

            // Gestione chiusura modal
            const modal = document.getElementById('eventModal');
            const closeModalBtn = document.getElementById('closeModal');

            closeModalBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Funzione di ordinamento della tabella
            function sortTableByColumn(table, column, asc = true, isDate = false, isTime = false) {
                const dirModifier = asc ? 1 : -1;
                const tBody = table.tBodies[0];
                const rows = Array.from(tBody.querySelectorAll('tr'));

                // Funzione per estrarre il valore da una cella, eventualmente parse data o ora
                const getCellValue = (row) => {
                    let cellText = row.querySelector(`td:nth-child(${column + 1})`).textContent.trim();
                    if (isDate) {
                        // parsing data formato "dd/mm/yyyy"
                        const parts = cellText.split('/');
                        if (parts.length === 3) {
                            return new Date(parts[2], parts[1] - 1, parts[0]);
                        }
                        return new Date(cellText); // fallback
                    } else if (isTime) {
                        // parsing ora formato "HH:mm"
                        const [h, m] = cellText.split(':').map(Number);
                        return h * 60 + m;
                    }
                    return cellText.toLowerCase();
                };

                // Ordino le righe
                const sortedRows = rows.sort((a, b) => {
                    const aVal = getCellValue(a);
                    const bVal = getCellValue(b);

                    if (aVal < bVal) {
                        return -1 * dirModifier;
                    }
                    if (aVal > bVal) {
                        return 1 * dirModifier;
                    }
                    return 0;
                });

                // Rimuovo le righe esistenti
                while (tBody.firstChild) {
                    tBody.removeChild(tBody.firstChild);
                }

                // Inserisco righe ordinate
                tBody.append(...sortedRows);

                // Aggiorno le classi e le icone di ordinamento
                table.querySelectorAll('th[data-sort]').forEach(th => {
                    th.classList.remove('asc', 'desc');
                    const icon = th.querySelector('.sort-icon');
                    if (icon) icon.textContent = '⇅';
                    icon.style.color = '#666';
                });

                const sortedTh = table.querySelectorAll('th[data-sort]')[column];
                if (sortedTh) {
                    sortedTh.classList.add(asc ? 'asc' : 'desc');
                    const icon = sortedTh.querySelector('.sort-icon');
                    if (icon) {
                        icon.textContent = asc ? '↑' : '↓';
                        icon.style.color = '#007bff';
                    }
                }
            }

            // Inizializzo variabili
            const table = document.querySelector('#list-container table');
            const headers = table.querySelectorAll('thead th[data-sort]');
            let sortColumnIndex = -1;
            let sortAsc = true;

            // Inserisco le span per l'icona in ogni th sortable se non già presente
            headers.forEach(th => {
                if (!th.querySelector('.sort-icon')) {
                    const span = document.createElement('span');
                    span.classList.add('sort-icon');
                    span.style.marginLeft = '5px';
                    span.style.fontSize = '0.8em';
                    span.style.color = '#666';
                    span.textContent = '⇅';
                    th.appendChild(span);
                }
            });

            headers.forEach((header, index) => {
                header.style.cursor = 'pointer';
                header.addEventListener('click', () => {
                    const sortKey = header.getAttribute('data-sort');
                    // Determino se è ordinamento data o orario
                    let isDate = false;
                    let isTime = false;

                    if (sortKey === 'date') {
                        isDate = true;
                    }
                    if (header.textContent.trim() === 'Ora Inizio' || header.textContent.trim() ===
                        'Ora Fine') {
                        isTime = true;
                    }

                    // Se clicco la stessa colonna, inverto l'ordine
                    if (sortColumnIndex === index) {
                        sortAsc = !sortAsc;
                    } else {
                        sortAsc = true;
                        sortColumnIndex = index;
                    }

                    sortTableByColumn(table, index, sortAsc, isDate, isTime);
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('#list-container table');
            const headers = table.querySelectorAll('th.sortable');
            let sortDirection = {};

            headers.forEach((header, index) => {
                header.addEventListener('click', () => {
                    const sortKey = header.getAttribute('data-sort');
                    const isDate = sortKey === 'date';
                    const isTime = sortKey === 'start' || sortKey === 'end';

                    // Inverti direzione sort se già cliccato
                    sortDirection[index] = !sortDirection[index];

                    sortTableByColumn(table, index, sortDirection[index], isDate, isTime);
                });
            });

            function sortTableByColumn(table, column, asc = true, isDate = false, isTime = false) {
                const dirModifier = asc ? 1 : -1;
                const tBody = table.tBodies[0];
                const rows = Array.from(tBody.querySelectorAll('tr'));

                const getCellValue = (row) => {
                    let cellText = row.children[column].textContent.trim();
                    if (isDate) {
                        const parts = cellText.split('/');
                        return parts.length === 3 ? new Date(parts[2], parts[1] - 1, parts[0]) : new Date(
                            cellText);
                    } else if (isTime) {
                        const [h, m] = cellText.split(':').map(Number);
                        return h * 60 + m;
                    }
                    return cellText.toLowerCase();
                };

                const sortedRows = rows.sort((a, b) => {
                    const aVal = getCellValue(a);
                    const bVal = getCellValue(b);

                    if (aVal < bVal) return -1 * dirModifier;
                    if (aVal > bVal) return 1 * dirModifier;
                    return 0;
                });

                // Appendo le righe ordinate
                sortedRows.forEach(row => tBody.appendChild(row));
            }
        });
    </script>



    <style>
        @layer components {
            .fc-event {
                cursor: pointer !important;
            }

            .fc .fc-toolbar-title {
                @apply text-blue-600 text-lg font-bold capitalize;
            }

            .fc-button {
                @apply bg-orange-500 text-white border border-orange-500 rounded px-2 py-1 text-sm hover:bg-orange-600 hover:border-orange-600;
            }

            .fc-prev-button,
            .fc-next-button {
                @apply bg-yellow-500 border-yellow-600 hover:bg-yellow-600;
            }

            .fc-today-button {
                @apply bg-blue-600 text-white hover:bg-blue-700;
            }
        }

        .fc-daygrid-day-number,
        .fc-col-header-cell-cushion {
            text-transform: capitalize !important;
        }

        #calendar {
            height: 600px !important;
        }

        /* Modal flexbox centering */
        #eventModal.flex {
            display: flex !important;
        }

        th.asc .sort-icon {
            font-size: 1.2em;
            /* aumentata da 0.8em */
            color: #007bff;
        }

        th.desc .sort-icon {
            font-size: 1.2em;
            /* aumentata da 0.8em */
            color: #007bff;
        }

        th.sortable {
            font-size: 1.0em;
            /* aumentata da 0.8em */
            position: relative;
            padding-right: 20px;
            user-select: none;
        }
    </style>
</x-app-layout>

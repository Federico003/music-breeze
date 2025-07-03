<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Lista Pagamenti') }}
            </h2>
            <x-primary-button onclick="window.location.href='{{ route('admin.create-payment') }}'"> Aggiungi Pagamento
            </x-primary-button>
        </div>
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
                                        <th class="px-4 py-3 font-semibold sortable">Mese/Anno <span
                                                class="sort-icon"></span></th>
                                        <th class="px-4 py-3 font-semibold sortable">Importo (€) <span
                                                class="sort-icon"></span></th>
                                        <th class="px-4 py-3 font-semibold">Azioni</th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-orange-200 dark:bg-gray-900 divide-y divide-orange-300 dark:divide-gray-700 text-black dark:text-white"
                                    id="payments-table-body">
                                    @foreach ($payments as $payment)
                                        <tr data-id="{{ $payment->id }}">
                                            <td class="px-4 py-3 whitespace-nowrap student-full-name">
                                                {{ $payment->student->name ?? '-' }}
                                                {{ $payment->student->surname ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap course-name">
                                                {{ $payment->course->name ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap payment-date">
                                                @if ($payment->month && $payment->year)
                                                    {{ $payment->month->name }} {{ $payment->year }}
                                                @else
                                                    {{ $payment->year }}
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap amount">
                                                {{ number_format($payment->amount, 2, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap actions-cell">
                                                <div class="flex items-center space-x-3">
                                                    <button type="button"
                                                        class="edit-btn text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-600 p-1"
                                                        title="Modifica">
                                                        <x-heroicon-s-pencil class="w-5 h-5" />
                                                    </button>

                                                    <button onclick="window.location.href='{{ route('admin.print-payment', $payment->id) }}'" type="button"
                                                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-600 p-1"
                                                        title="Scarica ricevuta">
                                                        <x-heroicon-s-document-arrow-down class="w-5 h-5 text-white"/>
                                                    </button>

                                                    <form action="{{ route('admin.destroy-payment', $payment->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Sei sicuro di voler eliminare questo pagamento?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Elimina"
                                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-600 p-1">
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
                    headers.forEach(h => h.classList.remove('asc', 'desc'));
                    header.classList.toggle('asc', !currentIsAscending);
                    header.classList.toggle('desc', currentIsAscending);
                    sortTableByColumn(table, index, !currentIsAscending);
                });
            });

            function sortTableByColumn(table, column, asc = true) {
                const dirModifier = asc ? 1 : -1;
                const tBody = table.tBodies[0];
                const rows = Array.from(tBody.querySelectorAll('tr'));

                const sortedRows = rows.sort((a, b) => {
                    let aText = a.children[column].textContent.trim();
                    let bText = b.children[column].textContent.trim();

                    const monthYearRegex = /^[a-zA-Z]+ \d{4}$/; // es: Marzo 2025
                    const numberRegex = /^[\d.,]+$/;

                    if (monthYearRegex.test(aText) && monthYearRegex.test(bText)) {
                        // Per ordinare mese/anno possiamo convertire il mese in numero e confrontare
                        const monthMap = {
                            'Gennaio': 1,
                            'Febbraio': 2,
                            'Marzo': 3,
                            'Aprile': 4,
                            'Maggio': 5,
                            'Giugno': 6,
                            'Luglio': 7,
                            'Agosto': 8,
                            'Settembre': 9,
                            'Ottobre': 10,
                            'Novembre': 11,
                            'Dicembre': 12
                        };
                        const [monthA, yearA] = aText.split(' ');
                        const [monthB, yearB] = bText.split(' ');
                        if (yearA !== yearB) return (parseInt(yearA) - parseInt(yearB)) * dirModifier;
                        return (monthMap[monthA] - monthMap[monthB]) * dirModifier;
                    } else if (numberRegex.test(aText) && numberRegex.test(bText)) {
                        const parseNum = str => parseFloat(str.replace('.', '').replace(',', '.'));
                        return (parseNum(aText) - parseNum(bText)) * dirModifier;
                    } else {
                        return aText.localeCompare(bText) * dirModifier;
                    }
                });

                tBody.innerHTML = '';
                tBody.append(...sortedRows);
            }
            // ---------------------------------------------

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
                const amountCell = row.querySelector('.amount');
                const actionsCell = row.querySelector('.actions-cell');

                const currentAmount = amountCell.textContent.trim().replace('.', '').replace(',', '.'); // float

                amountCell.innerHTML =
                    `<input type="number" step="0.01" min="0" class="edit-amount dark:text-black" value="${currentAmount}" />`;

                actionsCell.innerHTML = `
                    <button type="button" class="save-btn px-2 py-1 bg-green-600 text-white rounded" title="Salva">Salva</button>
                    <button type="button" class="cancel-btn px-2 py-1 bg-gray-500 text-white rounded ml-2" title="Annulla">Annulla</button>
                `;
            }

            function exitEditMode(row) {
                window.location.reload();
            }

            function saveEdit(row) {
                const paymentId = row.dataset.id;
                const amountInput = row.querySelector('.edit-amount');

                const amount = parseFloat(amountInput.value);

                if (isNaN(amount) || amount <= 0) {
                    alert('Inserisci un importo maggiore di 0.');
                    return;
                }

                fetch(`/admin/update-payment/${paymentId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            amount
                        }),
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Errore nella richiesta');
                        return response.json();
                    })
                    .then(data => {
                        window.location.reload();
                    })
                    .catch(error => {
                        alert('Errore nel salvataggio');
                        console.error(error);
                    });
            }
        });
    </script>
</x-app-layout>

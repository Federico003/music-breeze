<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Studenti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-grey-200 dark:bg-gray-900 shadow-sm sm:rounded-2xl m-6 mb-6">

                <div class="overflow-x-auto sm:rounded-lg bg-grey-200">
                    <x-table :headers="[
                        'ID',
                        'Nome',
                        'Cognome',
                        'Data di Nascita',
                        'Telefono',
                        'Email',
                        'Creato',
                        'Aggiornato',
                        '',
                    ]">
                        @foreach ($students as $student)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="px-4 py-3">{{ $student->id }}</td>
                                <td class="px-4 py-3">{{ $student->name }}</td>
                                <td class="px-4 py-3">{{ $student->surname }}</td>
                                <td class="px-4 py-3">{{ $student->birth_date->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ $student->phone }}</td>
                                <td class="px-4 py-3">{{ $student->email }}</td>
                                <td class="px-4 py-3">{{ $student->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ $student->updated_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-3">

                                        <a href=""
                                            title="Modifica"
                                            class="dark:text-white hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-600 p-2 m-2">
                                            <x-heroicon-s-document-currency-dollar />
                                        </a>


                                        {{-- Modifica --}}
                                        <a href="{{ route('admin.edit-user', ['id' => $student->id]) }}"
                                            title="Modifica"
                                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-600 p-2 m-2">
                                            <x-heroicon-s-pencil class="w-5 h-5" />
                                        </a>

                                        {{-- Stampa --}}
                                        <a href="{{ route('admin.print-user', ['id' => $student->id]) }}"
                                            title="Stampa"
                                            class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 p-2 m-2">
                                            <x-heroicon-s-printer class="w-5 h-5" />
                                        </a>

                                        {{-- Elimina --}}
                                        <form action="{{ route('admin.delete-user', ['id' => $student->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Sei sicuro di voler eliminare questo corso?')">
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
                    </x-table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

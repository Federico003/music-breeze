<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Insegnanti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-grey-200 dark:bg-gray-900 shadow-sm sm:rounded-2xl m-6 mb-6">

                <div class="overflow-x-auto sm:rounded-lg bg-grey-200">
                    <x-table :headers="['#', 'Nome', 'Cognome', 'Data di Nascita', 'Telefono', 'Email', 'Inserito il', 'Aggiornato', '']">
                        @foreach ($teachers as $teacher)
                            <tr class="hover:bg-orange-300 dark:hover:bg-gray-700 transition">
                                <td class="px-4 py-3">{{ $teacher->id }}</td>
                                <td class="px-4 py-3">{{ $teacher->name }}</td>
                                <td class="px-4 py-3">{{ $teacher->surname }}</td>
                                <td class="px-4 py-3">{{ $teacher->birth_date->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ $teacher->phone }}</td>
                                <td class="px-4 py-3">{{ $teacher->email }}</td>
                                <td class="px-4 py-3">{{ $teacher->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ $teacher->updated_at ->format('d/m/Y')}}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-3">

                                        {{-- Modifica --}}
                                        <a href="{{route('admin.edit-user', ['id' => $teacher->id])}}" title="Modifica"
                                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-600 p-1">
                                            <x-heroicon-s-pencil class="w-6 h-6" />
                                        </a>

                                        {{-- Stampa --}}
                                        <a href="{{route('admin.print-user', ['id' => $teacher->id])}}" title="Stampa"
                                            class="text-black hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 p-1">
                                            <x-heroicon-s-printer class="w-6 h-6" />
                                        </a>

                                        {{-- Elimina --}}
                                        <form action="{{route('admin.delete-user', ['id' => $teacher->id])}}" method="POST"
                                            onsubmit="return confirm('Sei sicuro di voler eliminare questo corso?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Elimina"
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-600 p-1">
                                                <x-heroicon-s-trash class="w-6 h-6" />
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

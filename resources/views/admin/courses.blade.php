<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Corsi') }}
        </h2>
        <x-primary-button onclick="window.location.href='{{ route('admin.create-course') }}'"> Aggiungi Corso </x-primary-button>
    </div>
</x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-grey-200 dark:bg-gray-900 shadow-sm sm:rounded-lg rounded-lg m-6 mb-6">

                 <div class="overflow-hidden rounded-lg shadow ring-1 ring-black ring-opacity-5">
                    <x-table :headers="['#', 'Nome', 'Descrizione', 'Inserito il', 'Aggiornato il', '']" >
                        @foreach ($courses as $course)
                            <tr class="hover:bg-orange-300 dark:hover:bg-gray-700 transition">
                                <td class="px-4 py-3">{{ $course->id }}</td>
                                <td class="px-4 py-3">{{ $course->name }}</td>
                                <td class="px-4 py-3">{{ $course->description }}</td>
                                <td class="px-4 py-3">{{ $course->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ $course->updated_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-3">
                                        {{-- Modifica --}}
                                        <a href="{{route('admin.edit-course', ['id' => $course->id])}}" title="Modifica"
                                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-600 p-1">
                                            <x-heroicon-s-pencil class="w-5 h-5" />
                                        </a>

                                        {{-- Stampa --}}
                                        <a href="{{route('admin.print-course', ['id' => $course->id])}}" title="Stampa"
                                            class="text-black hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 p-1">
                                            <x-heroicon-s-printer class="w-5 h-5" />
                                        </a>

                                        {{-- Elimina --}}
                                        <form action="{{route('admin.delete-course', ['id' => $course->id])}}" method="POST"
                                            onsubmit="return confirm('Sei sicuro di voler eliminare questo corso?')">
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
                    </x-table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

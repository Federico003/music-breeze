<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Altri Utenti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-grey-200 dark:bg-gray-900 shadow-sm sm:rounded-2xl m-6 mb-6">

                <div class="overflow-x-auto sm:rounded-lg bg-grey-200">
                    <x-table :headers="[
                        '#',
                        'Nome',
                        'Cognome',
                        'Data di Nascita',
                        'Telefono',
                        'Email',
                        'Creato',
                        'Aggiornato',
                        '',
                    ]">
                        @foreach ($users as $user)
                            <tr class="hover:bg-orange-300 dark:hover:bg-gray-700 transition">
                                <td class="px-4 py-3">{{ $user->id }}</td>
                                <td class="px-4 py-3">{{ $user->name }}</td>
                                <td class="px-4 py-3">{{ $user->surname }}</td>
                                <td class="px-4 py-3">{{ $user->birth_date->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ $user->phone }}</td>
                                <td class="px-4 py-3">{{ $user->email }}</td>
                                <td class="px-4 py-3">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ $user->updated_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-3">

                                        {{-- Modifica --}}
                                        <a href="{{ route('admin.edit-user', ['id' => $user->id]) }}" title="Modifica"
                                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-600 p-1">
                                            <x-heroicon-s-pencil class="w-6 h-6" />
                                        </a>

                                        {{-- Stampa --}}
                                        <a href="{{ route('admin.print-user', ['id' => $user->id]) }}" title="Stampa"
                                            class="text-black hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 p-1">
                                            <x-heroicon-s-printer class="w-6 h-6" />
                                        </a>

                                        {{-- Elimina --}}
                                        <!-- Bottone Elimina: SOLO se non è l’utente loggato -->
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Sei sicuro di voler eliminare questo utente?')">Elimina</button>
                                            </form>
                                        @endif
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

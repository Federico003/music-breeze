<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Studenti') }}
        </h2>
    </x-slot>

    <div class="py-6 dark:bg-grey-600">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 dark:bg-grey-600 ">
            <div class="bg-orange-200 shadow-xl  p-0 m-0  rounded-3xl dark:bg-gray-900">

                <div class="overflow-x-auto bg-orange-200 rounded-2xl bg-orange-200  dark:bg-gray-900">
                    <x-table :headers="[
                        'ID',
                        'Nome',
                        'Cognome',
                        'Data di Nascita',
                        'Telefono',
                        'Email',
                    ]">
                        @foreach ($students as $student)
                            <tr class="hover:bg-orange-300 dark:hover:bg-gray-700 transition">
                                <td class="px-4 py-3">{{ $student->id }}</td>
                                <td class="px-4 py-3">{{ $student->name }}</td>
                                <td class="px-4 py-3">{{ $student->surname }}</td>
                                <td class="px-4 py-3">{{ $student->birth_date->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ $student->phone }}</td>
                                <td class="px-4 py-3">{{ $student->email }}</td>
                                
                            </tr>
                        @endforeach
                    </x-table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

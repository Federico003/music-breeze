<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Insegnanti - Corsi') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 ">
        <div class="space-y-4 m-4">
            @foreach ($teachers as $index => $teacher)
                <div x-data="{ open: false }" class="rounded-xl shadow dark:bg-gray-700 bg-orange-300">
                    <!-- Intestazione accordion -->
                    <button @click="open = !open"
                        class="w-full px-4 py-2 text-left bg-orange-300 dark:bg-gray-700 dark:text-white hover:bg-orange-400 dark:hover:bg-gray-600 focus:outline-none flex justify-between items-center rounded-xl">
                        <span class="text-lg font-semibold">{{ $teacher->name }} {{ $teacher->surname }}</span>
                        <svg :class="{ 'rotate-180': open }" class="h-5 w-5 transform transition-transform duration-200"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Corpo accordion -->
                    <div x-show="open" x-transition class="px-4 py-4 rounded-xl dark:bg-gray-700 bg-orange-300">
                        <form action="{{ route('admin.update-teacher-courses', $teacher->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="flex flex-wrap gap-4 bg-orange-300 dark:bg-gray-700">
                                @foreach ($courses as $course)
                                    <label
                                        class="flex items-center min-w-[200px] dark:text-white dark:bg-gray-800 bg-orange-300 p-2 rounded">
                                        <input class="rounded dark:bg-grey-500 dark:text-grey-500" type="checkbox"
                                            name="corsi[]" value="{{ $course->id }}"
                                            {{ $teacher->courses->contains($course->id) ? 'checked' : '' }}
                                            class="form-checkbox">
                                        <span class="ml-2">{{ $course->name }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <button type="submit"
                                class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Salva corsi
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

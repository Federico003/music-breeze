<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Studenti - Corsi & Insegnanti') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="space-y-4 m-4">
            @foreach ($students as $student)
                <div x-data="{ open: false }" class="rounded-xl shadow dark:bg-gray-700 bg-orange-300">
                    <!-- Intestazione accordion -->
                    <button @click="open = !open"
                        class="w-full px-4 py-2 text-left bg-orange-300 dark:bg-gray-700 dark:text-white hover:bg-orange-400 dark:hover:bg-gray-600 focus:outline-none flex justify-between items-center rounded-xl">
                        <span class="text-lg font-semibold">{{ $student->name }} {{ $student->surname }}</span>
                        <svg :class="{ 'rotate-180': open }" class="h-5 w-5 transform transition-transform duration-200"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Corpo accordion -->
                    <div x-show="open" x-transition class="px-4 py-4 rounded-xl text-black dark:text-white dark:bg-gray-700 bg-orange-300">
                        <form action="{{ route('admin.update-student-courses', $student->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid md:grid-cols-2 gap-4 bg-orange-300 dark:bg-gray-700">
                                @foreach ($courses as $course)
                                    <h4>{{ $course->name }}</h4>
                                    @php
                                        $enrollment = $student->courseEnrollments->firstWhere('id', $course->id);
                                        $selectedTeacherId = $enrollment ? $enrollment->pivot->teacher_id : null;
                                    @endphp
                                    <select name="courses_teachers[{{ $course->id }}]" class="form-select text-black dark:border-gray-800 border-gray-300 dark:bg-gray-800 dark:text-white rounded p-1">
                                        <option value="">Seleziona docente (Corso attualmente non selezionato)</option>
                                        @foreach ($course->teachers as $teacher)
                                            <option value="{{ $teacher->id }}"
                                                @if ($teacher->id == $selectedTeacherId) selected @endif>
                                                {{ $teacher->name }} {{ $teacher->surname }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endforeach


                            </div>

                            <button type="submit"
                                class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Salva
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

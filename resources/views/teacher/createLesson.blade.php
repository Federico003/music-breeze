@php
    $studentOptions =
        ['' => '--Seleziona Studente--'] +
        $students
            ->mapWithKeys(function ($student) {
                return [$student->id => $student->name . ' ' . $student->surname];
            })
            ->toArray();

    $courseOptions =
        ['' => '--Seleziona Corso--'] +
        $courses
            ->mapWithKeys(function ($course) {
                return [$course->id => $course->name];
            })
            ->toArray();
@endphp


<x-app-layout>
    <div class="min-h-screen flex justify-center items-center bg-orange-50 dark:bg-gray-900 py-12">
        <div class="w-full max-w-xl bg-orange-100 dark:bg-gray-800 p-6 rounded-2xl shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-200 mb-6">Registra una Lezione</h2>

            <form method="POST" action="{{ route('insegnante.store-lesson') }}" class="flex flex-col items-center">
                @csrf

                <div class="w-full max-w-sm mt-4">
                    <x-input-label for="student_id" :value="__('Studente')" />
                    {{-- <x-select-input name="student_id" class="w-full" :options="$studentOptions" required /> --}}
                    <select name="student_id" id="student_id" class="w-full rounded border-gray-300">
                        <option value="">-- Seleziona Studente --</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} {{ $student->surname }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                </div>

                <div class="w-full max-w-sm mt-4">
                    <x-input-label for="course_id" :value="__('Corso')" />
                    <select name="course_id" id="course_id" class="w-full rounded border-gray-300" required>
                        <option value="">-- Seleziona Corso --</option>
                        {{-- Popolato via JS --}}
                    </select>
                    <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                </div>

                <div class="w-full max-w-sm mt-4">
                    <x-input-label for="day" :value="__('Data Lezione')" />
                    <x-text-input id="day" class="w-full mt-1" type="date" name="day" :value="old('day')"
                        required autofocus autocomplete="day" />
                    <x-input-error :messages="$errors->get('day')" class="mt-2" />
                </div>

                <div class="w-full max-w-sm mt-4">
                    <x-input-label for="time" :value="__('Orario Lezione')" />
                    <x-text-input id="time" class="w-full mt-1" type="time" name="time" :value="old('time')"
                        required autofocus autocomplete="time" />
                    <x-input-error :messages="$errors->get('time')" class="mt-2" />
                </div>

                <div class="w-full max-w-sm mt-4">
                    <x-input-label for="duration" :value="__('Durata (Minuti)')" />
                    <x-text-input id="duration" class="w-full mt-1" type="number" name="duration" :value="old('duration')"
                        required autofocus autocomplete="duration" />
                    <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                </div>

                <div class="mt-6">
                    <x-primary-button>
                        {{ __('Registra Lezione') }}
                    </x-primary-button>
                </div>
                {{-- Successo --}}
                @if (session('success'))
                    <div class="alert alert-success mt-4 text-green-700 bg-green-100 p-3 rounded">
                        {{ session('success') }}
                    </div>
                @else
                    <div class="alert alert-success mt-4 text-red-700 bg-red-100 p-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif
            </form>
        </div>
    </div>
    <script>
        document.getElementById('student_id').addEventListener('change', function() {
            const studentId = this.value;
            //console.log(studentId);
            const courseSelect = document.getElementById('course_id');
            courseSelect.innerHTML = '<option value="">-- Seleziona Corso --</option>'; // reset

            if (studentId) {
                fetch(`/insegnante/get-courses/${studentId}`)
                    .then(response => response.json())
                    .then(courses => {
                        courses.forEach(course => {
                            const option = document.createElement('option');
                            //console.log(course.name);
                            option.value = course.id;
                            option.textContent = course.name;
                            courseSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Errore nel caricamento corsi:', error);
                    });
            }
        });
    </script>

</x-app-layout>

<x-app-layout>
    <form method="POST" action="{{ route('insegnante.store-lesson') }}" >
         @csrf
        <select name="student_id">
            @foreach ($students as $student)
                <option value="{{ $student->id }}">{{ $student->name }}</option>
            @endforeach
        </select>

        <select name="course_id">
            @foreach ($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
        </select>

        <input type="date" name="day">
        <input type="time" name="time">
        <input type="number" name="duration">

        <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-3">
                        {{ __('Registra Lezione') }}
                    </x-primary-button>
                </div>
    </form>
</x-app-layout>

<x-app-layout>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900 w-full">
        <a href="/">
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </a>

        <h1 class="text-black dark:text-white text-2xl font-semibold mt-4 mb-6">Gestione pagamenti</h1>

        <div class="w-full sm:max-w-2xl px-6 py-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <form method="POST" action="{{route('admin.store-payment')}}">
                @csrf

                {{-- Studente --}}
                <div class="mb-4">
                    <x-input-label for="student_id" :value="__('Seleziona Studente')" />
                    <select name="student_id" id="student_id"
                        class="form-control selectpicker block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        data-live-search="true" required>
                        <option value="">{{ __('Seleziona studente') }}</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} {{ $student->surname }}</option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <p class="text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Corso (inizialmente nascosto) --}}
                <div id="course-container" class="mb-4 hidden">
                    <x-input-label for="course_id" :value="__('Seleziona Corso')" />
                    <select name="course_id" id="course_id"
                        class="form-control selectpicker block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        data-live-search="true" required>
                        <option value="">{{ __('-- Seleziona corso --') }}</option>
                    </select>
                    @error('course_id')
                        <p class="text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tipo pagamento --}}
                <div id="payment-type-container" class="mb-4 hidden">
                    <label
                        class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Tipo di pagamento') }}</label>
                    <div class="mt-2">
                        @foreach ($paymentsTypes as $type)
                            <label class="inline-flex items-center mr-6 cursor-pointer">
                                <input type="radio" class="payment-radio form-radio text-indigo-600"
                                    id="payment_type_{{ $type->id }}" name="payment_type_id"
                                    value="{{ $type->id }}" data-type-name="{{ strtolower($type->name) }}">
                                <span class="ml-2 text-gray-700 dark:text-gray-300">{{ $type->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('payment_type_id')
                        <p class="text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dettagli dinamici pagamento --}}
                <div id="dynamic-payment-detail" class="mb-4">
                    <div id="monthly-detail" class="hidden">
                        <x-input-label for="month" :value="__('Seleziona Mese')" />
                        <select name="month" id="month"
                            class="form-control selectpicker block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">{{ __('-- Seleziona mese --') }}</option>
                            @foreach ($months as $month)
                                <option value="{{ $month->id }}">{{ $month->name }}</option>
                            @endforeach
                        </select>
                        <x-input-label for="year_monthly" :value="__('Anno')" class="mt-4" />
                        <input type="number" name="year_monthly" id="year_monthly" min="2000" max="2100"
                            class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>
                    <div id="annual-detail" class="hidden">
                        <x-input-label for="year_annual" :value="__('Anno')" />
                        <input type="number" name="year_annual" id="year_annual" min="2000" max="2100"
                            class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>
                </div>


                {{-- Importo --}}
                <div id="amount-container" class="mb-4 hidden">
                    <x-input-label for="amount" :value="__('Importo (€)')" />
                    <input type="number" name="amount" id="amount" step="0.01" min="0"
                        class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required/>
                    @error('amount')
                        <p class="text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" id="submit-button"
                    class="hidden inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    {{ __('Registra Pagamento') }}
                </button>

                {{-- Errori --}}
                @if ($errors->any())
                    <div class="alert alert-danger mt-4 text-red-700 bg-red-100 p-3 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Successo --}}
                @if (session('success'))
                    <div class="alert alert-success mt-4 text-green-700 bg-green-100 p-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const studentSelect = document.getElementById('student_id');
            const courseContainer = document.getElementById('course-container');
            const courseSelect = document.getElementById('course_id');
            const paymentTypeContainer = document.getElementById('payment-type-container');
            const amountContainer = document.getElementById('amount-container');
            const submitButton = document.getElementById('submit-button');
            const paymentRadios = document.querySelectorAll('.payment-radio');
            const monthlyDetail = document.getElementById('monthly-detail');
            const annualDetail = document.getElementById('annual-detail');

            // Mostra il corso dopo la selezione dello studente
            studentSelect.addEventListener('change', function() {
                if (this.value) {
                    courseContainer.classList.remove('hidden');
                    // Carica i corsi per lo studente selezionato
                    fetch(`/admin/payment/students/${this.value}/courses`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(courses => {
                            courseSelect.innerHTML =
                                '<option value="">{{ __('-- Seleziona corso --') }}</option>';
                            courses.forEach(course => {
                                const option = document.createElement('option');
                                option.value = course.id;
                                option.textContent = course.name;
                                courseSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Errore nel fetch:', error);
                        });
                } else {
                    courseContainer.classList.add('hidden');
                    paymentTypeContainer.classList.add('hidden');
                    amountContainer.classList.add('hidden');
                    submitButton.classList.add('hidden');
                }
            });

            // Mostra il tipo di pagamento dopo la selezione del corso
            courseSelect.addEventListener('change', function() {
                if (this.value) {
                    paymentTypeContainer.classList.remove('hidden');
                } else {
                    paymentTypeContainer.classList.add('hidden');
                    amountContainer.classList.add('hidden');
                    submitButton.classList.add('hidden');
                }
            });

            // Mostra i dettagli dinamici del pagamento dopo la selezione del tipo di pagamento
            paymentRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const selectedType = this.dataset.typeName;
                    console.log(selectedType);

                    // Nascondi tutti i dettagli dinamici
                    monthlyDetail.classList.add('hidden');
                    annualDetail.classList.add('hidden');

                    if (selectedType === 'mensile') {
                        monthlyDetail.classList.remove('hidden');
                    } else if (selectedType === 'annuale') {
                        annualDetail.classList.remove('hidden');
                    }

                    amountContainer.classList.remove('hidden');
                    submitButton.classList.remove('hidden');
                });
            });
        });
    </script>
</x-app-layout>

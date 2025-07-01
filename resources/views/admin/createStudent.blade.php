<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    @include('layouts.navigation')
    <div class="flex flex-col items-center pt-10 bg-orange-100 dark:bg-gray-900 min-h-screen">

        <div class="text-black dark:text-white text-3xl">
            NUOVO STUDENTE
        </div>


        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">


            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('admin.store-student') }}">
                @csrf

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="name" :value="__('Nome')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="surname" :value="__('Cognome')" />
                    <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname"
                        :value="old('surname')" required autofocus autocomplete="surname" />
                    <x-input-error :messages="$errors->get('surname')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="birth_date" :value="__('Data di Nascita')" />
                    <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date"
                        :value="old('birth_date')" required autofocus autocomplete="birth_date" />
                    <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="birth_place" :value="__('Luogo di Nascita (Città o Stato Estero)')" />
                    <x-text-input id="birth_place" class="block mt-1 w-full" type="text" name="birth_place"
                        :value="old('birth_place')" required autofocus autocomplete="birth_place" />
                    <x-input-error :messages="$errors->get('birth_place')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="gender" :value="__('Sesso')" />
                    <x-select-input name="gender" :options="['M' => 'Maschio', 'F' => 'Femmina', 'X' => 'Non specificato']" required />
                    <x-input-error :messages="$errors->get('gender-place')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="address" :value="__('Indirizzo')" />
                    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address"
                        :value="old('address')" required autofocus autocomplete="address" />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="city" :value="__('Comune')" />
                    <x-text-input id="city" class="block mt-1 w-full" type="text" name="city"
                        :value="old('city')" required autofocus autocomplete="city" />
                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="country" :value="__('Stato')" />
                    <x-text-input id="country" class="block mt-1 w-full" type="text" name="country"
                        :value="old('country')" required autofocus autocomplete="country" />
                    <x-input-error :messages="$errors->get('country')" class="mt-2" />
                </div>
                    

                <div class="mt-4">
                    <x-input-label for="postal_code" :value="__('CAP')" />
                    <x-text-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code"
                        :value="old('postal_code')" required autofocus autocomplete="postal_code" inputmode="numeric" />
                    <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
                </div>




                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="phone" :value="__('Telefono')" />
                    <x-text-input id="telephone_number" class="block mt-1 w-full" type="text" name="phone"
                        :value="old('phone')" required autofocus autocomplete="phone" inputmode="numeric" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-3">
                        {{ __('Registra Studente') }}
                    </x-primary-button>
                </div>
            </form>

        </div>
    </div>
</body>

</html>

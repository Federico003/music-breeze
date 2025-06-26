@php
    $role = Auth::user()->userType?->name ?? '';
    //echo "Role: $role";
@endphp

<x-app-layout>
    <style>
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"> --}}
            {{-- <div class="p-6 text-gray-900 dark:text-gray-100"> --}}
            {{-- {{ __("You're logged in!") }} --}}

            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">


                {{-- {{ dd($role) }} --}}
                @if ($role === 'admin')
                    {{-- <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link> --}}

                    {{-- <x-nav-link :href="route('admin.ingredienti')" :active="request()->routeIs('admin.ingredienti')">
                                {{ __('Ingredienti') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.pizze')" :active="request()->routeIs('admin.pizze')">
                                {{ __('Pizze') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.pizzeIngredienti')" :active="request()->routeIs('admin.pizzeIngredienti')">
                                {{ __('Pizze - Ingredienti') }}
                            </x-nav-link> --}}
                @endif

            </div>


            {{-- </div> --}}

            <section class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-orange-300 dark:bg-gray-800 rounded-xl shadow-md p-6 m-4 card-hover transition duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-black dark:text-gray-400">Studenti</p>
                            <h3 class="text-2xl font-bold text-indigo-600">142</h3>
                        </div>
                        <div
                            class="w-12 h-12 rounded-full bg-indigo-100 dark:bg-indigo-600 flex items-center justify-center text-indigo-600 dark:text-indigo-200">
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="currentColor"
                                    d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192l42.7 0c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0L21.3 320C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7l42.7 0C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3l-213.3 0zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352l117.3 0C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7l-330.7 0c-14.7 0-26.7-11.9-26.7-26.7z" />
                            </svg>
                        </div>
                    </div>
                    {{-- <div class="mt-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400"><span
                                class="text-green-500 font-medium">+12%</span>
                            rispetto al mese scorso</p>
                    </div> --}}
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 m-4 card-hover transition duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-black-500 dark:text-gray-400">Docenti</p>
                            <h3 class="text-2xl font-bold text-orange-600 dark:text-indigo-600">18</h3>
                        </div>
                        <div
                            class="w-12 h-12 rounded-full bg-orange-100 dark:bg-indigo-600 flex items-center justify-center text-orange-600 dark:text-indigo-200">
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="currentColor"
                                    d="M208 352c-2.4 0-4.8 .4-7.1 1.1C188 357.3 174.4 360 160 360c-14.4 0-28-2.7-41-6.9-2.3-.7-4.7-1.1-7.1-1.1C49.9 352-.3 402.5 0 464.6 .1 490.9 21.7 512 48 512h224c26.3 0 47.9-21.1 48-47.4 .3-62.1-49.9-112.6-112-112.6zm-48-32c53 0 96-43 96-96s-43-96-96-96-96 43-96 96 43 96 96 96zM592 0H208c-26.5 0-48 22.3-48 49.6V96c23.4 0 45.1 6.8 64 17.8V64h352v288h-64v-64H384v64h-76.2c19.1 16.7 33.1 38.7 39.7 64H592c26.5 0 48-22.3 48-49.6V49.6C640 22.3 618.5 0 592 0z" />
                            </svg>
                        </div>
                    </div>
                    {{-- <div class="mt-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400"><span
                                class="text-green-500 font-medium">+2</span> nuovi
                            docenti</p>
                    </div> --}}
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 m-4 card-hover transition duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Lezioni oggi</p>
                            <h3 class="text-2xl font-bold text-indigo-600">24</h3>
                        </div>
                        <div
                            class="w-12 h-12 rounded-full bg-indigo-100 dark:bg-indigo-600 flex items-center justify-center text-indigo-600 dark:text-indigo-200">
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="currentColor"
                                    d="M128 0c17.7 0 32 14.3 32 32l0 32 128 0 0-32c0-17.7 14.3-32 32-32s32 14.3 32 32l0 32 48 0c26.5 0 48 21.5 48 48l0 48L0 160l0-48C0 85.5 21.5 64 48 64l48 0 0-32c0-17.7 14.3-32 32-32zM0 192l448 0 0 272c0 26.5-21.5 48-48 48L48 512c-26.5 0-48-21.5-48-48L0 192zm64 80l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm128 0l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zM64 400l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zm112 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16z" />
                            </svg>
                        </div>
                    </div>
                    {{-- <div class="mt-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400"><span
                                class="text-red-500 font-medium">3</span> lezioni
                            mancanti</p>
                    </div> --}}
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 m-4 card-hover transition duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Pagamenti</p>
                            <h3 class="text-2xl font-bold text-indigo-600">€8,420</h3>
                        </div>
                        <div
                            class="w-12 h-12 rounded-full bg-indigo-100 dark:bg-indigo-600 flex items-center justify-center text-indigo-600 dark:text-indigo-200">
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 320 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="currentColor"
                                    d="M48.1 240c-.1 2.7-.1 5.3-.1 8l0 16c0 2.7 0 5.3 .1 8L32 272c-17.7 0-32 14.3-32 32s14.3 32 32 32l28.3 0C89.9 419.9 170 480 264 480l24 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-24 0c-57.9 0-108.2-32.4-133.9-80L256 336c17.7 0 32-14.3 32-32s-14.3-32-32-32l-143.8 0c-.1-2.6-.2-5.3-.2-8l0-16c0-2.7 .1-5.4 .2-8L256 240c17.7 0 32-14.3 32-32s-14.3-32-32-32l-125.9 0c25.7-47.6 76-80 133.9-80l24 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-24 0C170 32 89.9 92.1 60.3 176L32 176c-17.7 0-32 14.3-32 32s14.3 32 32 32l16.1 0z" />
                            </svg>
                        </div>
                    </div>
                    {{-- <div class="mt-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400"><span
                                class="text-yellow-500 font-medium">€1,240</span> in attesa</p>
                    </div> --}}
                </div>
            </section>


            <section class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 m-4 dark:text-gray-200">Azioni Rapide</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 ">
                    <button onclick="window.location.href='{{ route('admin.create-student') }}'"
                        class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 m-4 flex flex-col items-center justify-center hover:bg-indigo-100 dark:hover:bg-indigo-700 transition duration-300">
                        <div
                            class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-600 flex items-center justify-center text-indigo-600 dark:text-indigo-200 mb-2">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="currentColor"
                                    d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM504 312l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                            </svg>
                        </div>
                        <span class="text-gray-700 dark:text-gray-400">Nuovo Studente</span>
                    </button>

                    <button onclick="window.location.href='{{ route('admin.create-teacher') }}'"
                        class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 m-4 flex flex-col items-center justify-center hover:bg-indigo-100 dark:hover:bg-indigo-700 transition duration-300">
                        <div
                            class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-600 flex items-center justify-center text-indigo-600 dark:text-indigo-200 mb-2">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="currentColor"
                                    d="M160 64c0-35.3 28.7-64 64-64L576 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64l-239.2 0c-11.8-25.5-29.9-47.5-52.4-64l99.6 0 0-32c0-17.7 14.3-32 32-32l64 0c17.7 0 32 14.3 32 32l0 32 64 0 0-288L224 64l0 49.1C205.2 102.2 183.3 96 160 96l0-32zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352l53.3 0C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7L26.7 512C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z" />
                            </svg>
                        </div>
                        <span class="text-gray-700 dark:text-gray-400">Nuovo Insegnante</span>
                    </button>

                    <button
                        class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 m-4 flex flex-col items-center justify-center hover:bg-indigo-100 dark:hover:bg-indigo-700 transition duration-300">
                        <div
                            class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-600 flex items-center justify-center text-indigo-600 dark:text-indigo-200 mb-2">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="currentColor"
                                    d="M436 160H12c-6.6 0-12-5.4-12-12v-36c0-26.5 21.5-48 48-48h48V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h128V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h48c26.5 0 48 21.5 48 48v36c0 6.6-5.4 12-12 12zM12 192h424c6.6 0 12 5.4 12 12v260c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V204c0-6.6 5.4-12 12-12zm316 140c0-6.6-5.4-12-12-12h-60v-60c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v60h-60c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h60v60c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12v-60h60c6.6 0 12-5.4 12-12v-40z" />
                            </svg>
                        </div>
                        <span class="text-gray-700 dark:text-gray-400">Nuova Lezione</span>
                    </button>

                    <button onclick="window.location.href='{{ route('admin.create-payment') }}'"
                        class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 m-4 flex flex-col items-center justify-center hover:bg-indigo-100 dark:hover:bg-indigo-700 transition duration-300">
                        <div
                            class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-600 flex items-center justify-center text-indigo-600 dark:text-indigo-200 mb-2">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="currentColor"
                                    d="M64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-288-128 0c-17.7 0-32-14.3-32-32L224 0 64 0zM256 0l0 128 128 0L256 0zM64 80c0-8.8 7.2-16 16-16l64 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L80 96c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16l64 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-64 0c-8.8 0-16-7.2-16-16zm128 72c8.8 0 16 7.2 16 16l0 17.3c8.5 1.2 16.7 3.1 24.1 5.1c8.5 2.3 13.6 11 11.3 19.6s-11 13.6-19.6 11.3c-11.1-3-22-5.2-32.1-5.3c-8.4-.1-17.4 1.8-23.6 5.5c-5.7 3.4-8.1 7.3-8.1 12.8c0 3.7 1.3 6.5 7.3 10.1c6.9 4.1 16.6 7.1 29.2 10.9l.5 .1s0 0 0 0s0 0 0 0c11.3 3.4 25.3 7.6 36.3 14.6c12.1 7.6 22.4 19.7 22.7 38.2c.3 19.3-9.6 33.3-22.9 41.6c-7.7 4.8-16.4 7.6-25.1 9.1l0 17.1c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-17.8c-11.2-2.1-21.7-5.7-30.9-8.9c0 0 0 0 0 0c-2.1-.7-4.2-1.4-6.2-2.1c-8.4-2.8-12.9-11.9-10.1-20.2s11.9-12.9 20.2-10.1c2.5 .8 4.8 1.6 7.1 2.4c0 0 0 0 0 0s0 0 0 0s0 0 0 0c13.6 4.6 24.6 8.4 36.3 8.7c9.1 .3 17.9-1.7 23.7-5.3c5.1-3.2 7.9-7.3 7.8-14c-.1-4.6-1.8-7.8-7.7-11.6c-6.8-4.3-16.5-7.4-29-11.2l-1.6-.5s0 0 0 0c-11-3.3-24.3-7.3-34.8-13.7c-12-7.2-22.6-18.9-22.7-37.3c-.1-19.4 10.8-32.8 23.8-40.5c7.5-4.4 15.8-7.2 24.1-8.7l0-17.3c0-8.8 7.2-16 16-16z" />
                            </svg>
                        </div>
                        <span class="text-gray-700 dark:text-gray-400">Nuovo Pagamento</span>
                    </button>


                    <button onclick="window.location.href='{{ route('admin.teacher-courses') }}'"
                        class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 m-4 flex flex-col items-center justify-center hover:bg-indigo-100 dark:hover:bg-indigo-700 transition duration-300">
                        <div
                            class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-600 flex items-center justify-center text-indigo-600 dark:text-indigo-200 mb-2">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="currentColor"
                                    d="M579.8 267.7c56.5-56.5 56.5-148 0-204.5c-50-50-128.8-56.5-186.3-15.4l-1.6 1.1c-14.4 10.3-17.7 30.3-7.4 44.6s30.3 17.7 44.6 7.4l1.6-1.1c32.1-22.9 76-19.3 103.8 8.6c31.5 31.5 31.5 82.5 0 114L422.3 334.8c-31.5 31.5-82.5 31.5-114 0c-27.9-27.9-31.5-71.8-8.6-103.8l1.1-1.6c10.3-14.4 6.9-34.4-7.4-44.6s-34.4-6.9-44.6 7.4l-1.1 1.6C206.5 251.2 213 330 263 380c56.5 56.5 148 56.5 204.5 0L579.8 267.7zM60.2 244.3c-56.5 56.5-56.5 148 0 204.5c50 50 128.8 56.5 186.3 15.4l1.6-1.1c14.4-10.3 17.7-30.3 7.4-44.6s-30.3-17.7-44.6-7.4l-1.6 1.1c-32.1 22.9-76 19.3-103.8-8.6C74 372 74 321 105.5 289.5L217.7 177.2c31.5-31.5 82.5-31.5 114 0c27.9 27.9 31.5 71.8 8.6 103.9l-1.1 1.6c-10.3 14.4-6.9 34.4 7.4 44.6s34.4 6.9 44.6-7.4l1.1-1.6C433.5 260.8 427 182 377 132c-56.5-56.5-148-56.5-204.5 0L60.2 244.3z" />
                            </svg>
                        </div>
                        <span class="text-gray-700 dark:text-gray-400">Collega Insegnanti e Corsi</span>
                    </button>


                    <button onclick="window.location.href='{{ route('admin.student-courses') }}'"
                        class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 m-4 flex flex-col items-center justify-center hover:bg-indigo-100 dark:hover:bg-indigo-700 transition duration-300">
                        <div
                            class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-600 flex items-center justify-center text-indigo-600 dark:text-indigo-200 mb-2">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="currentColor"
                                    d="M579.8 267.7c56.5-56.5 56.5-148 0-204.5c-50-50-128.8-56.5-186.3-15.4l-1.6 1.1c-14.4 10.3-17.7 30.3-7.4 44.6s30.3 17.7 44.6 7.4l1.6-1.1c32.1-22.9 76-19.3 103.8 8.6c31.5 31.5 31.5 82.5 0 114L422.3 334.8c-31.5 31.5-82.5 31.5-114 0c-27.9-27.9-31.5-71.8-8.6-103.8l1.1-1.6c10.3-14.4 6.9-34.4-7.4-44.6s-34.4-6.9-44.6 7.4l-1.1 1.6C206.5 251.2 213 330 263 380c56.5 56.5 148 56.5 204.5 0L579.8 267.7zM60.2 244.3c-56.5 56.5-56.5 148 0 204.5c50 50 128.8 56.5 186.3 15.4l1.6-1.1c14.4-10.3 17.7-30.3 7.4-44.6s-30.3-17.7-44.6-7.4l-1.6 1.1c-32.1 22.9-76 19.3-103.8-8.6C74 372 74 321 105.5 289.5L217.7 177.2c31.5-31.5 82.5-31.5 114 0c27.9 27.9 31.5 71.8 8.6 103.9l-1.1 1.6c-10.3 14.4-6.9 34.4 7.4 44.6s34.4 6.9 44.6-7.4l1.1-1.6C433.5 260.8 427 182 377 132c-56.5-56.5-148-56.5-204.5 0L60.2 244.3z" />
                            </svg>
                        </div>
                        <span class="text-gray-700 dark:text-gray-400">Collega Studenti e Corsi</span>
                    </button>



                    {{-- <button class="bg-white rounded-lg shadow p-4 flex flex-col items-center justify-center hover:bg-indigo-50 transition duration-300">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mb-2">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Invia Notifica</span>
                </button> --}}
                </div>
            </section>


            {{-- </div> --}}
        </div>
    </div>
</x-app-layout>

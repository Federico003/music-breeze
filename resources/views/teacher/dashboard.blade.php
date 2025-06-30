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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <section class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 m-4 card-hover transition duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-black-500 dark:text-gray-400">STUDENTI</p>
                            <h3 class="text-2xl font-bold text-orange-600 dark:text-indigo-600">18</h3>
                        </div>
                        <div
                            class="w-12 h-12 rounded-full bg-orange-100 dark:bg-indigo-600 flex items-center justify-center text-orange-600 dark:text-indigo-200">
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="currentColor"
                                    d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192l42.7 0c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0L21.3 320C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7l42.7 0C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3l-213.3 0zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352l117.3 0C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7l-330.7 0c-14.7 0-26.7-11.9-26.7-26.7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 m-4 card-hover transition duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-black-500 dark:text-gray-400">LEZIONI OGGI</p>
                            <h3 class="text-2xl font-bold text-orange-600 dark:text-indigo-600">18</h3>
                        </div>
                        <div
                            class="w-12 h-12 rounded-full bg-orange-100 dark:bg-indigo-600 flex items-center justify-center text-orange-600 dark:text-indigo-200">
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="currentColor"
                                    d="M128 0c17.7 0 32 14.3 32 32l0 32 128 0 0-32c0-17.7 14.3-32 32-32s32 14.3 32 32l0 32 48 0c26.5 0 48 21.5 48 48l0 48L0 160l0-48C0 85.5 21.5 64 48 64l48 0 0-32c0-17.7 14.3-32 32-32zM0 192l448 0 0 272c0 26.5-21.5 48-48 48L48 512c-26.5 0-48-21.5-48-48L0 192zm64 80l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm128 0l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zM64 400l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zm112 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </section>


            <section class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 m-4 dark:text-gray-200">Azioni Rapide</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 ">
                    

                    

                    <button onclick="window.location.href='{{ route('insegnante.create-lesson') }}'"
                        class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 m-4 flex flex-col items-center justify-center hover:bg-orange-100 dark:hover:bg-indigo-700 transition duration-300">
                        <div
                            class="w-10 h-10 rounded-full bg-orange-100 dark:bg-indigo-600 flex items-center justify-center text-orange-600 dark:text-indigo-200 mb-2">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="currentColor"
                                    d="M436 160H12c-6.6 0-12-5.4-12-12v-36c0-26.5 21.5-48 48-48h48V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h128V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h48c26.5 0 48 21.5 48 48v36c0 6.6-5.4 12-12 12zM12 192h424c6.6 0 12 5.4 12 12v260c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V204c0-6.6 5.4-12 12-12zm316 140c0-6.6-5.4-12-12-12h-60v-60c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v60h-60c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h60v60c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12v-60h60c6.6 0 12-5.4 12-12v-40z" />
                            </svg>
                        </div>
                        <span class="text-gray-700 dark:text-gray-400">NUOVA LEZIONE</span>
                    </button>

                    <button onclick="window.location.href='{{ route('insegnante.show-lessons') }}'"
                    class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 m-4 flex flex-col items-center justify-center hover:bg-indigo-100 dark:hover:bg-indigo-700 transition duration-300">
                    <div
                        class="w-10 h-10 rounded-full bg-orange-100 dark:bg-indigo-600 flex items-center justify-center text-orange-600 dark:text-indigo-200 mb-2">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                            <path fill="currentColor"
                                d="M96 32l0 32L48 64C21.5 64 0 85.5 0 112l0 48 448 0 0-48c0-26.5-21.5-48-48-48l-48 0 0-32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 32L160 64l0-32c0-17.7-14.3-32-32-32S96 14.3 96 32zM448 192L0 192 0 464c0 26.5 21.5 48 48 48l352 0c26.5 0 48-21.5 48-48l0-272z" />
                        </svg>
                    </div>
                    <span class="text-gray-700 dark:text-gray-400">CALENDARIO LEZIONI</span>
                </button>

                </div>
            </section>
            
        </div>
    </div>
</x-app-layout>
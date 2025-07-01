<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rock Music Academy| Scuola di Musica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #FF7D34;
            --primary-light: #FF9D57;
            --primary-dark: #E66821;
            --secondary: #1E1E1E;
            --light: #F5F5F5;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0px);
            }
        }

        @keyframes noteFloat {
            0% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-15px) rotate(5deg);
            }

            100% {
                transform: translateY(0) rotate(0deg);
            }
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light);
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            min-height: 80vh;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            animation: fadeIn 1s ease-out;
        }

        .btn-primary {
            background-color: var(--secondary);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .course-card {
            transition: all 0.3s ease;
            border-bottom: 4px solid var(--primary);
        }

        .course-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .teacher-card {
            transition: all 0.3s ease;
        }

        .teacher-card:hover {
            transform: scale(1.03);
        }

        .testimonial-card {
            background: white;
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .note {
            position: absolute;
            color: rgba(255, 255, 255, 0.4);
            font-size: 2rem;
            animation: noteFloat 3s infinite ease-in-out;
        }

        .section-title {
            position: relative;
            display: inline-block;
        }

        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -10px;
            width: 70px;
            height: 4px;
            background: var(--primary);
        }

        .floating-element {
            animation: float 6s ease-in-out infinite;
        }

        .fade-in {
            animation: fadeIn 1s ease-out;
        }

        footer {
            background: var(--secondary);
            color: white;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header fixed w-full z-50 bg-orange-800">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <!-- LOGO a sinistra -->
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo_rma.png') }}" alt="Logo dell'azienda" class="w-14 h-auto">
                </a>

                <!-- MENU e LOGIN -->
                <div class="flex items-center justify-between w-full ml-6">
                    <nav class="hidden md:flex justify-between items-center w-full">
                        <ul class="flex space-x-8">
                            <li><a href="#"
                                    class="text-white hover:text-orange-400 font-medium transition duration-300">Home</a></li>
                            <li><a href="#courses"
                                    class="text-white hover:text-orange-400 font-medium transition duration-300">Corsi</a></li>
                            <li><a href="#teachers"
                                    class="text-white hover:text-orange-400 font-medium transition duration-300">Insegnanti</a>
                            </li>
                            {{-- <li><a href="#about" class="text-gray-800 hover:text-orange-500 font-medium transition">Chi Siamo</a></li> --}}
                            <li><a href="#contact"
                                    class="text-white hover:text-orange-400 font-medium transition duration-300">Contatti</a></li>
                        </ul>

                        <!-- LOGIN / DASHBOARD -->
                        <div class="ml-auto">
                            @auth
                                @php
                                    $user = auth()->user();
                                    $role = strtolower($user->userType?->name ?? 'guest');
                                    $dashboardUrl = match ($role) {
                                        'admin' => '/admin/dashboard',
                                        'insegnante' => '/insegnante/dashboard',
                                        'studente' => '/studente/dashboard',
                                        default => '/',
                                    };
                                @endphp
                                <a href="{{ url($dashboardUrl) }}"
                                    class="inline-block px-5 py-1.5 text-white border border-white bg-transparent transition duration-300 ease-in-out rounded-sm text-sm leading-normal hover:bg-[#FF7D34]/90 hover:border-[#FF7D34]">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-block px-5 py-1.5 text-white border border-white bg-transparent transition duration-300 ease-in-out rounded-sm text-sm leading-normal hover:bg-[#FF7D34]/90 hover:border-[#FF7D34]">
                                    Log in
                                </a>
                            @endauth
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>


    <!-- Hero Section -->
    <section class="hero text-white pt-32 pb-20 md:pb-32">
        <!-- Musical notes floating around -->
        <div class="note" style="top: 20%; left: 10%;">♪</div>
        <div class="note" style="top: 60%; left: 80%; animation-delay: 0.5s;">♫</div>
        <div class="note" style="top: 30%; left: 70%; animation-delay: 1s;">♪</div>
        <div class="note" style="top: 70%; left: 20%; animation-delay: 1.5s;">♫</div>

        <div class="container mx-auto px-6 relative">
            <div class="hero-content flex flex-col md:flex-row items-center">
                <div class="md:w-1/2">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                        Scopri il <span class="text-secondary">musicista</span> che è in te
                    </h1>
                    <p class="text-xl mb-8">
                        La nostra scuola offre corsi di alta qualità per tutte le età e livelli. Impara, suona e
                        condividi la tua passione per la musica.
                    </p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="#courses"
                            class="btn-primary px-8 py-4 rounded-full font-medium text-lg inline-block text-center">
                            Scopri i Corsi
                        </a>
                        <a href="#contact"
                            class="bg-white text-gray-800 px-8 py-4 rounded-full font-medium text-lg inline-block text-center hover:bg-gray-100 transition">
                            Contattaci
                        </a>
                    </div>
                </div>

                <div class="md:w-1/2 mt-12 md:mt-0 md:pl-12 floating-element">
                    <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/e1cd0d8c-2907-4e38-a605-561d56ef8d2b.png"
                        alt="Gruppo di studenti felici che suonano diversi strumenti musicali insieme in una sala prove"
                        class="rounded-lg shadow-xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Section -->
    <section id="courses" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 fade-in">
                <h2 class="section-title text-3xl md:text-4xl font-bold text-gray-800 inline-block">
                    I Nostri Corsi
                </h2>
                <p class="mt-6 text-gray-600 max-w-2xl mx-auto">
                    Offriamo un'ampia gamma di corsi per tutti i livelli e tutte le età. Scegli lo strumento che ami e
                    inizia il tuo viaggio musicale con noi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Course 1 -->
                <div class="course-card bg-white rounded-lg overflow-hidden shadow-md">
                    <div
                        class="h-48 bg-gradient-to-r from-primary-light to-primary flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/guitar.png') }}" alt="Logo dell'azienda"
                            class="w-full h-full object-cover object-[50%_35%]">
                    </div>


                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Chitarra</h3>
                        <p class="text-gray-600 mb-4">Impara tutti gli stili dalla classica al rock. Corsi per
                            principianti e avanzati.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-primary font-bold">€50/mese</span>
                            <a href="#" class="text-sm text-primary hover:text-primary-dark font-medium">Scopri di
                                più →</a>
                        </div>
                    </div>
                </div>

                <!-- Course 2 -->
                <div class="course-card bg-white rounded-lg overflow-hidden shadow-md">
                    <div
                        class="h-48 bg-gradient-to-r from-primary-light to-primary flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/piano.png') }}" alt="Logo dell'azienda"
                            class="w-full h-full object-cover object-[50%_45%]">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Pianoforte</h3>
                        <p class="text-gray-600 mb-4">Tecnica, teoria e repertorio. Per tutte le età e livelli.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-primary font-bold">€60/mese</span>
                            <a href="#" class="text-sm text-primary hover:text-primary-dark font-medium">Scopri di
                                più →</a>
                        </div>
                    </div>
                </div>

                <!-- Course 3 -->
                <div class="course-card bg-white rounded-lg overflow-hidden shadow-md">
                    <div
                        class="h-48 bg-gradient-to-r from-primary-light to-primary flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/drums.png') }}" alt="Logo dell'azienda"
                            class="w-full h-full object-cover object-[50%_32%]">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Batteria</h3>
                        <p class="text-gray-600 mb-4">Ritmo, coordinazione e stili moderni. Sala prove attrezzata.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-primary font-bold">€55/mese</span>
                            <a href="#" class="text-sm text-primary hover:text-primary-dark font-medium">Scopri di
                                più →</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="#"
                    class="inline-block px-8 py-3 bg-primary text-white rounded-full font-medium hover:bg-primary-dark transition">
                    Vedi Tutti i Corsi
                </a>
            </div>
        </div>
    </section>

    <!-- Teachers Section -->
    <section id="teachers" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="section-title text-3xl md:text-4xl font-bold text-gray-800 inline-block">
                    I Nostri Insegnanti
                </h2>
                <p class="mt-6 text-gray-600 max-w-2xl mx-auto">
                    Professionisti esperti e appassionati che ti guideranno nel tuo percorso musicale con dedizione e
                    competenza.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Teacher 1 -->
                <div class="teacher-card bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative">
                        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/ccd0a688-5637-46e4-9bf6-8287e3892a9f.png"
                            alt="Marco Bianchi, insegnante di chitarra con esperienza ventennale nell'insegnamento"
                            class="w-full h-64 object-cover">
                        <div class="absolute top-4 right-4 flex space-x-2">
                            <a href="#"
                                class="bg-white w-8 h-8 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#"
                                class="bg-white w-8 h-8 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-1">Marco Bianchi</h3>
                        <p class="text-primary mb-3">Chitarra</p>
                        <p class="text-gray-600 text-sm">Diplomato al Conservatorio di Milano con 20 anni di esperienza
                            nell'insegnamento.</p>
                    </div>
                </div>

                <!-- Teacher 2 -->
                <div class="teacher-card bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative">
                        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/9063c298-f36c-45c9-9161-17eb204b4716.png"
                            alt="Laura Rossi, insegnante di pianoforte classico e jazz con numerosi premi internazionali"
                            class="w-full h-64 object-cover">
                        <div class="absolute top-4 right-4 flex space-x-2">
                            <a href="#"
                                class="bg-white w-8 h-8 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#"
                                class="bg-white w-8 h-8 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-1">Laura Rossi</h3>
                        <p class="text-primary mb-3">Pianoforte</p>
                        <p class="text-gray-600 text-sm">Premiata concertista internazionale con specializzazione in
                            jazz e musica classica.</p>
                    </div>
                </div>

                <!-- Teacher 3 -->
                <div class="teacher-card bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative">
                        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/57023f60-f26b-42c4-bc01-2104c7637959.png"
                            alt="Giovanni Verdi, batterista professionista con esperienza in tour mondiali"
                            class="w-full h-64 object-cover">
                        <div class="absolute top-4 right-4 flex space-x-2">
                            <a href="#"
                                class="bg-white w-8 h-8 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#"
                                class="bg-white w-8 h-8 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-1">Giovanni Verdi</h3>
                        <p class="text-primary mb-3">Batteria</p>
                        <p class="text-gray-600 text-sm">Batterista professionista con tour internazionali all'attivo e
                            passione per l'insegnamento.</p>
                    </div>
                </div>

                <!-- Teacher 4 -->
                <div class="teacher-card bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative">
                        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/760a594d-7815-4e19-b319-61bf2564788f.png"
                            alt="Sofia Neri, insegnante di canto lirico e moderno con formazione accademica"
                            class="w-full h-64 object-cover">
                        <div class="absolute top-4 right-4 flex space-x-2">
                            <a href="#"
                                class="bg-white w-8 h-8 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#"
                                class="bg-white w-8 h-8 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-1">Sofia Neri</h3>
                        <p class="text-primary mb-3">Canto</p>
                        <p class="text-gray-600 text-sm">Mezzosoprano con formazione accademica e specializzazione in
                            tecniche vocali moderne.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-primary text-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="section-title text-3xl text-gray-800 md:text-4xl font-bold inline-block">
                    Cosa Dicono di Noi
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="testimonial-card p-6 rounded fade-in">
                    <div class="flex items-center mb-4">
                        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/1a0a30ae-8735-4267-a65a-2f75e176fc06.png"
                            alt="Elena, studentessa di pianoforte da 2 anni all'accademia"
                            class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold text-gray-800">Elena</h4>
                            <p class="text-primary text-sm">Studente di pianoforte</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "Ho iniziato da zero due anni fa e ora riesco a suonare i miei brani preferiti. Gli insegnanti
                        sono pazienti e preparati."
                    </p>
                    <div class="flex mt-4">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="testimonial-card p-6 rounded fade-in" style="animation-delay: 0.2s;">
                    <div class="flex items-center mb-4">
                        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/3b3b36b5-6654-45a4-a627-7aa6211c43ca.png"
                            alt="Paolo, padre di un giovane studente di batteria" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold text-gray-800">Paolo</h4>
                            <p class="text-primary text-sm">Genitore</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "Mio figlio frequenta da un anno e ha fatto progressi incredibili. L'ambiente è stimolante e
                        professionale."
                    </p>
                    <div class="flex mt-4">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="testimonial-card p-6 rounded fade-in" style="animation-delay: 0.4s;">
                    <div class="flex items-center mb-4">
                        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/6d4b3b46-f6c1-419d-ab52-86975a04b7e6.png"
                            alt="Giulia, studentessa adulta di canto" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-bold text-gray-800">Giulia</h4>
                            <p class="text-primary text-sm">Studente di canto</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "A 35 anni ho deciso di realizzare il mio sogno di cantare e ho trovato qui la scuola perfetta
                        per le mie esigenze."
                    </p>
                    <div class="flex mt-4">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="section-title text-3xl md:text-4xl font-bold text-gray-800 inline-block">
                        Contattaci
                    </h2>
                    <p class="mt-6 text-gray-600">
                        Hai domande? Vuoi maggiori informazioni sui nostri corsi? Compila il form e ti risponderemo al
                        più presto.
                    </p>
                </div>

                <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-gray-700 mb-2">Nome</label>
                        <input type="text" id="name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700 mb-2">Email</label>
                        <input type="email" id="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div class="md:col-span-2">
                        <label for="subject" class="block text-gray-700 mb-2">Oggetto</label>
                        <input type="text" id="subject"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div class="md:col-span-2">
                        <label for="message" class="block text-gray-700 mb-2">Messaggio</label>
                        <textarea id="message" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                    </div>
                    <div class="md:col-span-2 text-center">
                        <button type="submit"
                            class="px-8 py-3 bg-primary text-white rounded-full font-medium hover:bg-primary-dark transition">
                            Invia Messaggio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Rock Music Academy</h3>
                    <p class="text-gray-400">
                        La tua scuola di musica per imparare, crescere e condividere la passione per la musica.
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Link Veloci</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="#courses" class="text-gray-400 hover:text-white transition">Corsi</a></li>
                        <li><a href="#teachers" class="text-gray-400 hover:text-white transition">Insegnanti</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition">Chi Siamo</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition">Contatti</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Orari</h3>
                    <ul class="text-gray-400 space-y-2">
                        <li>Lun-Ven: 15:00 - 20:00</li>
                        <li>Sabato e Domenica: Chiuso</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Contatti</h3>
                    <ul class="text-gray-400 space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-primary"></i> Via Fratelli Baccari 15, Lendinra - RO
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2 text-primary"></i> +39 0425 123456
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2 text-primary"></i> info@rockmusicacademy.it
                        </li>
                    </ul>
                    <div class="flex space-x-4 mt-4">
                        <a href="https://www.facebook.com/rockmusicacademy"
                            class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-white hover:bg-primary transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/rockmusicacademy/"
                            class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-white hover:bg-primary transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/@rmarockmusicacademy1068"
                            class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-white hover:bg-primary transition">
                            <i class="fab fa-youtube"></i>
                        </a>

                        <a href="https://www.tiktok.com/@rmarockmusicacade?_t=8a2VdfeX81G&_r=1"
                            class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-white hover:bg-primary transition">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>Copyrights 2025 © RMA - Rock Music Academy, Associazione culturale musicale</p>
            </div>
        </div>
    </footer>

    <script>
        // Simple animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const fadeElements = document.querySelectorAll('.fade-in');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            fadeElements.forEach(el => {
                el.style.opacity = 0;
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });

            // Mobile menu toggle would go here
        });
    </script>
</body>

</html>

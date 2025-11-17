<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Incluimos Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Incluimos Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Incluimos la librería de animación AOS (CSS) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Incluimos Swiper.js para el carrusel (CSS) -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
        html {
            overflow-x: hidden;
            scroll-behavior: smooth; /* Para un scroll suave al hacer clic en los enlaces del menú */
        }
        /* Estilos para la animación del subrayado en el menú */
        .nav-link {
            position: relative;
            text-decoration: none;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #f59e0b; /* Color ámbar de Tailwind */
            transition: width 0.3s ease-in-out;
        }
        .nav-link:hover::after {
            width: 100%;
        }

        /* Estilos personalizados para los carruseles */
        .swiper-button-next,
        .swiper-button-prev {
            color: #f59e0b; /* Color ámbar */
        }
        .swiper-pagination-bullet-active {
            background-color: #f59e0b; /* Color ámbar */
        }

        /* --- NUEVA ANIMACIÓN PARA EL TEXTO DEL HERO CAROUSEL --- */
        .hero-text-content {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .hero-swiper .swiper-slide-active .hero-text-content {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 0.4s; /* Retraso para esperar a que la imagen de fondo cambie */
        }
    </style>
</head>
<body class="bg-gray-100">

<!-- Header -->
<header id="main-header" class="fixed top-0 left-0 right-0 z-20 text-white transition-all duration-300">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="text-2xl font-bold font-serif drop-shadow-lg">
            <a href="#">{{ config('app.name', 'Laravel') }}</a>
        </div>

        <!-- Menú de Escritorio -->
        <ul class="hidden md:flex space-x-8 items-center text-sm drop-shadow-lg">
            <li><a href="#services" class="nav-link">Servicios</a></li>
            <li><a href="#gallery" class="nav-link">Galería</a></li>
            <li><a href="#testimonials" class="nav-link">Testimonios</a></li>
            <li><a href="#contact" class="nav-link">Contacto</a></li>
            <li><a href="{{url('/hlogin')}}" class="nav-link">Administración</a></li>
{{--            <li><a href="#" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-full transition-all duration-300 hover:shadow-lg hover:shadow-amber-500/50">Reservar Ahora</a></li>--}}
        </ul>

        <!-- Botón del Menú Móvil -->
        <button id="mobile-menu-button" class="md:hidden focus:outline-none drop-shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </nav>

    <!-- Menú Desplegable Móvil -->
    <div id="mobile-menu" class="hidden md:hidden bg-gray-900 bg-opacity-90 backdrop-blur-sm">
        <ul class="flex flex-col items-center space-y-4 py-4">
            <li><a href="#services" class="block py-2 px-4 text-sm hover:bg-amber-500 rounded-md">Servicios</a></li>
            <li><a href="#gallery" class="block py-2 px-4 text-sm hover:bg-amber-500 rounded-md">Galería</a></li>
            <li><a href="#testimonials" class="block py-2 px-4 text-sm hover:bg-amber-500 rounded-md">Testimonios</a></li>
            <li><a href="#contact" class="block py-2 px-4 text-sm hover:bg-amber-500 rounded-md">Contacto</a></li>
            <li><a href="{{url('/hlogin')}}" class="nav-link">Administración</a></li>
{{--            <li><a href="#" class="mt-2 bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded-full transition-colors">Reservar Ahora</a></li>--}}
        </ul>
    </div>
</header>

<main>
    <!-- Hero Section con Carrusel -->
    <section class="relative h-screen">
        <div class="swiper hero-swiper h-full">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover" alt="Lobby de hotel de lujo">
                    <div class="absolute inset-0 flex items-center justify-center text-white">
                        <div class="hero-text-content text-center px-4">
                            <h1 class="text-5xl md:text-7xl font-serif font-bold mb-4 drop-shadow-lg">Tu Refugio de Lujo</h1>
                            <p class="text-lg md:text-xl max-w-2xl mx-auto drop-shadow-md mb-8">Experimenta un servicio incomparable y una comodidad excepcional.</p>
                            <a href="#" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded-full text-lg transition-transform transform hover:scale-105">Ver Habitaciones</a>
                        </div>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbb5b9?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover" alt="Piscina de hotel">
                    <div class="absolute inset-0 flex items-center justify-center text-white">
                        <div class="hero-text-content text-center px-4">
                            <h1 class="text-5xl md:text-7xl font-serif font-bold mb-4 drop-shadow-lg">Relajación Infinita</h1>
                            <p class="text-lg md:text-xl max-w-2xl mx-auto drop-shadow-md mb-8">Sumérgete en nuestra piscina y olvida el estrés de la ciudad.</p>
                            <a href="#" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded-full text-lg transition-transform transform hover:scale-105">Descubre el Spa</a>
                        </div>
                    </div>
                </div>
                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                    <img src="https://images.unsplash.com/photo-1564501049412-61c2a3083791?q=80&w=1932&auto=format&fit=crop" class="w-full h-full object-cover" alt="Vista exterior de hotel">
                    <div class="absolute inset-0 flex items-center justify-center text-white">
                        <div class="hero-text-content text-center px-4">
                            <h1 class="text-5xl md:text-7xl font-serif font-bold mb-4 drop-shadow-lg">Una Estancia Inolvidable</h1>
                            <p class="text-lg md:text-xl max-w-2xl mx-auto drop-shadow-md mb-8">Cada detalle está diseñado para hacer de tu visita una experiencia única.</p>
                            <a href="#" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded-full text-lg transition-transform transform hover:scale-105">Reservar Ahora</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Add Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div data-aos="fade-up">
                <h2 class="text-4xl font-serif font-bold text-center text-gray-800 mb-2">Nuestros Servicios</h2>
                <p class="text-center text-gray-500 mb-12">Diseñados para tu máximo confort y conveniencia.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Service Card 1 -->
                <div class="relative group bg-gray-50 rounded-lg shadow-md overflow-hidden transform hover:-translate-y-2 transition-transform duration-300" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute inset-0 bg-gradient-to-t from-amber-500 to-transparent opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <div class="p-6 relative">
                        <div class="mb-4 text-amber-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Lavandería</h3>
                        <p class="text-gray-600 text-sm">Servicio rápido y eficiente para que tu ropa esté siempre impecable.</p>
                    </div>
                </div>
                <!-- Service Card 2 -->
                <div class="relative group bg-gray-50 rounded-lg shadow-md overflow-hidden transform hover:-translate-y-2 transition-transform duration-300" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute inset-0 bg-gradient-to-t from-amber-500 to-transparent opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <div class="p-6 relative">
                        <div class="mb-4 text-amber-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v6m3-6v6m3-6v6M3 16a2 2 0 012-2h14a2 2 0 012 2M3 12a2 2 0 012-2h14a2 2 0 012 2" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Alimentación</h3>
                        <p class="text-gray-600 text-sm">Disfruta de una experiencia culinaria excepcional en nuestro restaurante.</p>
                    </div>
                </div>
                <!-- Service Card 3 -->
                <div class="relative group bg-gray-50 rounded-lg shadow-md overflow-hidden transform hover:-translate-y-2 transition-transform duration-300" data-aos="fade-up" data-aos-delay="300">
                    <div class="absolute inset-0 bg-gradient-to-t from-amber-500 to-transparent opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <div class="p-6 relative">
                        <div class="mb-4 text-amber-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Servicios para Negocios</h3>
                        <p class="text-gray-600 text-sm">Salas de reuniones equipadas con la última tecnología para tu éxito.</p>
                    </div>
                </div>
                <!-- Service Card 4 -->
                <div class="relative group bg-gray-50 rounded-lg shadow-md overflow-hidden transform hover:-translate-y-2 transition-transform duration-300" data-aos="fade-up" data-aos-delay="400">
                    <div class="absolute inset-0 bg-gradient-to-t from-amber-500 to-transparent opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <div class="p-6 relative">
                        <div class="mb-4 text-amber-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Transfers</h3>
                        <p class="text-gray-600 text-sm">Traslados privados desde y hacia el aeropuerto con total comodidad.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div data-aos="fade-up">
                <h2 class="text-4xl font-serif font-bold text-center text-gray-800 mb-2">Galería de Habitaciones</h2>
                <p class="text-center text-gray-500 mb-12">Espacios diseñados para tu descanso</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($roomTypes as $roomType)
                    <div class="group relative overflow-hidden rounded-lg shadow-lg" data-aos="fade-up" data-aos-delay="100">
                        <img src="{{ asset('storage/'.$roomType->roomtypeimgs()->first()->img_src )}}" class="w-full h-full object-cover aspect-square transform group-hover:scale-110 transition-transform duration-500" alt="Habitación suite">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-500 flex items-center justify-center">
                            <h4 class="text-white text-lg font-bold opacity-0 group-hover:opacity-100 transition-opacity duration-500">{{ $roomType->title }}</h4>
{{--                            <p class="text-white text-lg font-bold opacity-0 group-hover:opacity-100 transition-opacity duration-500">{{ $roomType->detail }}</p>--}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-gray-800 text-white overflow-hidden">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-serif font-bold mb-12" data-aos="fade-up">Lo que dicen nuestros huéspedes</h2>

            <!-- Swiper Carousel -->
            <div class="swiper testimonial-swiper max-w-3xl mx-auto" data-aos="fade-up">
                <div class="swiper-wrapper">
                    <!-- Testimonial Slide 1 -->
                    <div class="swiper-slide">
                        <div class="bg-gray-700 p-8 rounded-xl shadow-lg">
                            <p class="text-xl italic mb-6">"Mi estancia en el Hotel Arc fue excepcional. El personal me hizo sentir como en casa. ¡Impecable!"</p>
                            <p class="font-bold text-amber-400">- María González</p>
                        </div>
                    </div>
                    <!-- Testimonial Slide 2 -->
                    <div class="swiper-slide">
                        <div class="bg-gray-700 p-8 rounded-xl shadow-lg">
                            <p class="text-xl italic mb-6">"La ubicación es inmejorable y las vistas desde la habitación son espectaculares. Volveré sin dudarlo."</p>
                            <p class="font-bold text-amber-400">- Juan Pérez</p>
                        </div>
                    </div>
                    <!-- Testimonial Slide 3 -->
                    <div class="swiper-slide">
                        <div class="bg-gray-700 p-8 rounded-xl shadow-lg">
                            <p class="text-xl italic mb-6">"El restaurante superó todas mis expectativas. Una experiencia culinaria de primer nivel. Muy recomendado."</p>
                            <p class="font-bold text-amber-400">- Ana García</p>
                        </div>
                    </div>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination mt-8 relative"></div>
                <!-- Add Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>

</main>

<!-- Footer -->
<footer id="contact" class="bg-gray-900 text-white">
    <div class="container mx-auto px-6 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h4 class="text-lg font-bold font-serif mb-4">Hotel Arc</h4>
                <p class="text-gray-400 text-sm">Tu hogar lejos de casa, con el lujo y la comodidad que mereces.</p>
            </div>
            <div>
                <h4 class="text-lg font-bold mb-4">Enlaces Rápidos</h4>
                <ul class="text-gray-400 text-sm space-y-2">
                    <li><a href="#" class="hover:text-amber-400">Inicio</a></li>
                    <li><a href="#services" class="hover:text-amber-400">Servicios</a></li>
                    <li><a href="#gallery" class="hover:text-amber-400">Galería</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-bold mb-4">Síguenos</h4>
                <div class="flex space-x-4">
                    <!-- Placeholder for social icons -->
                    <a href="#" class="text-gray-400 hover:text-white">FB</a>
                    <a href="#" class="text-gray-400 hover:text-white">IG</a>
                    <a href="#" class="text-gray-400 hover:text-white">TW</a>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-6 text-center text-gray-500 text-sm">
            <p>&copy; 2025 Hotel Arc. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<!-- Incluimos la librería de animación AOS (JS) -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- Incluimos Swiper.js (JS) -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- Script para el menú, AOS y Swiper -->
<script>
    // Inicializamos AOS
    AOS.init({
        duration: 800, // Duración de la animación en milisegundos
        once: true,     // La animación solo ocurre una vez
    });

    // Inicializamos Swiper para el carrusel de testimonios
    const testimonialSwiper = new Swiper('.testimonial-swiper', {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 30,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    // Inicializamos Swiper para el carrusel del Hero
    const heroSwiper = new Swiper('.hero-swiper', {
        loop: true,
        effect: 'fade',
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    // Lógica para el menú móvil
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // Lógica para cambiar el fondo del header al hacer scroll
    const header = document.getElementById('main-header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('bg-gray-900', 'bg-opacity-90', 'backdrop-blur-sm', 'shadow-lg');
        } else {
            header.classList.remove('bg-gray-900', 'bg-opacity-90', 'backdrop-blur-sm', 'shadow-lg');
        }
    });
</script>
</body>
</html>

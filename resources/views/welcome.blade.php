<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@800&display=swap" rel="stylesheet">

    <!-- Incluir CSS -->
    <link rel="stylesheet" href="{{ asset('css/tailwindcss.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public.css') }}">
    
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-logo">
            <img src="{{ asset('images/public/logo.png') }}" alt="Logo" class="logo">
        </div>
        <div class="navbar-links">
            <a href="#inicio">Inicio</a>
            <a href="#blog">Blog</a>
            <a href="#guias">Guías</a>
            <a href="#programas">Programas</a>
            <a href="#eventos">Eventos</a>
            <a href="#contacto">Contacto</a>
        </div>
    </nav>

    <!-- Secciones -->
    <div id="inicio">
            
        <div class="background-container" style="background-image: url('{{ asset('images/public/inicio.jpg') }}');">
            <!-- Aquí puedes colocar contenido adicional para la sección de Inicio -->
            <div class="wave-container">
                <svg viewBox="0 0 900 310">
                    <path transform="translate(0, -150)" fill="#F8F7F7" fill-opacity="1" d="M0,224L48,218.7C96,213,192,203,288,213.3C384,224,480,256,576,256C672,256,768,224,864,192C960,160,1056,128,1152,117.3C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                </svg>
            </div>
        </div>
    </div>

    <section id="blog">
        <h2>Blog</h2>
        <p>Contenido del Blog.</p>
    </section>

    <section id="guias">
        <h2>Guías</h2>
        <p>Contenido de las Guías.</p>
    </section>

    <section id="programas">
        <h2>Programas</h2>
        <p>Contenido de los Programas.</p>
    </section>

    <section id="eventos">
        <h2>Eventos</h2>
        <p>Contenido de los Eventos.</p>
    </section>

    <section id="contacto">
        <h2>Contacto</h2>
        <p>Información de Contacto.</p>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 Tu Empresa. Todos los derechos reservados.</p>
            <div class="footer-links">
                <a href="#inicio">Inicio</a>
                <a href="#blog">Blog</a>
                <a href="#guias">Guías</a>
                <a href="#programas">Programas</a>
                <a href="#eventos">Eventos</a>
                <a href="#contacto">Contacto</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}">Administrar</a>
                    @else
                        <a href="{{ route('login') }}">Iniciar sesión</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Registarse</a>
                    @endif
                @endauth
            @endif
            </div>
        </div>
    </footer>

    <!-- Incluir JS -->
    <script src="{{ asset('js/public.js') }}"></script>
</body>
</html>
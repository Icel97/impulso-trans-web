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
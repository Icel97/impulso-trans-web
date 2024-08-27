@extends('layouts.public')

@section('content')
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

<!-- Programas -->
<section id="programas" class="mt-5">
    <div class="container">
        <h2>Programas</h2>
        <p>Información sobre nuestros programas de apoyo.</p>
    </div>
</section>

<!-- Eventos -->
<section id="eventos" class="mt-5">
    <div class="container">
        <h2>Eventos</h2>
        <p>Conoce nuestros próximos eventos.</p>
    </div>
</section>
    <!-- Mapa de Documentación Estatal -->
<section id="mapa" class="mt-5">
    <div class="container">
        <h2>Mapa de Documentación Estatal</h2>
        <p>Consulta los documentos necesarios por estado.</p>
        <!-- Aquí se incluiría el mapa interactivo -->
    </div>
</section>

<!-- Testimonios -->
<section id="testimonios" class="mt-5">
    <div class="container">
        <h2>Testimonios</h2>
        <p>Lee lo que otros tienen que decir.</p>
    </div>
</section>

    <section id="contacto">
        <h2>Contacto</h2>
        <p>Información de Contacto.</p>
    </section>
@endsection

    

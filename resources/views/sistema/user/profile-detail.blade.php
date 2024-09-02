<div class="card w-100" style="margin:0 !important">
    <div>
        <div class="d-flex flex-column align-items-center py-4" style="background: var(--gray-dark)">
            <img src="{{ $usuario->profile_photo_url ?? asset('blank-profile-picure-1024x1024.webp') }}"
                alt="Foto de perfil" width="200" height="200"
                class="rounded-circle py-2 bg-white border border-gray-300 shadow-sm">
        </div>
        <div class="row w-100 px-4" style="margin-top: 2rem;">
            <div class="col-md-6 col-sm-12">
                <p class="font-weight-bold">Nombre</p>
                <p class="card-text">{{ $usuario->name ?? '-' }}</p>
            </div>
            <div class="col-md-6 col-sm-12">
                <p class="font-weight-bold">Apellidos</p>
                <p class="card-text">{{ $usuario->apellidos ?? '-' }}</p>
            </div>
        </div>
        <div class="row w-100 px-4" style="margin-top: 2rem;">
            <div class="col-md-6 col-sm-12">
                <p class="font-weight-bold">Correo</p>
                <p class="card-text">{{ $usuario->email ?? '-' }}</p>
            </div>
            <div class="col-md-6 col-sm-12">
                <p class="font-weight-bold">Identidad de Género</p>
                <p class="card-text">{{ $usuario->identidad_genero ?? '-' }}</p>
            </div>
        </div>
        <div class="row w-100 px-4" style="margin-top: 2rem;">
            <div class="col-md-6 col-sm-12">
                <p class="font-weight-bold">Pronombres</p>
                <p class="card-text">{{ $usuario->pronombres ?? '-' }}</p>
            </div>
            <div class="col-md-6 col-sm-12">
                <p class="font-weight-bold">Fecha de Nacimiento</p>
                <p class="card-text">{{ $usuario->fecha_nacimiento ?? '-' }}</p>
            </div>
        </div>
        <div class="row w-100 px-4" style="margin-top: 2rem;">

            <div class="col-md-6 col-sm-12">
                <p class="font-weight-bold">Teléfono</p>
                <p class="card-text">{{ $usuario->telefono ?? '-' }}</p>
            </div>
            <div class="col-md-6 col-sm-12">
                <p class="font-weight-bold">Municipio</p>
                <p class="card-text">{{ $usuario->municipio ?? '-' }}</p>
            </div>
        </div>
        <div class="row w-100 px-4" style="margin-top: 2rem;">

            <div class="col-md-6 col-sm-12">
                <p class="font-weight-bold">Discapacidad</p>
                <p class="card-text">{{ $usuario->discapacidad ?? '-' }}</p>
            </div>
            <div class="col-md-6 col-sm-12">
                <p class="font-weight-bold">Neurodivergencia</p>
                <p class="card-text">{{ $usuario->neurodivergencia ?? '-' }}</p>
            </div>
        </div>
        <div class="row w-100 px-4" style="margin-block: 2rem;">

            <div class="col-md-6 col-sm-12">
                <p class="font-weight-bold">Indígena</p>
                <p class="card-text">{{ $usuario->indigena ?? '-' }}</p>
            </div>
            <div class="col-md-6 col-sm-12">
                <p class="font-weight-bold">Afrodescendiente</p>
                <p class="card-text">{{ $usuario->afrodescendiente ?? '-' }}</p>
            </div>
        </div>
    </div>

</div>

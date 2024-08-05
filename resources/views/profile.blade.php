@extends('adminlte::page')

@section('title', 'Impulso trans - Mi Perfil')

@section('content_header')
    <h1> </h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Mi perfil</h1>
        </div>
        <div class="card-body">
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    @livewire('profile.update-profile-information-form')

                <x-section-border />

                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div class="mt-10 sm:mt-0">
                        @livewire('profile.update-password-form')
                    </div>

                @endif
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @livewireStyles
@stop

@section('js')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear una cuenta | IT</title>

    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <link rel="stylesheet" href="css/style.css">
    @section('adminlte_css')
        @stack('css')
        @yield('css')
    @stop
</head>
<body>

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
@endif

    <div class="main">

        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <form method="POST" id="signup-form" class="signup-form " action="{{ $register_url }}">
                        @csrf
                        <h2 class="form-title">Crear Cuenta</h2>
                        <div class="form-group">
                            <input type="text" class="form-input @error('name') is-invalid @enderror" name="name" id="name"
                            value="{{ old('name') }}" placeholder="{{ __('adminlte::adminlte.full_name') }}" autofocus/>
                            <span class="zmdi zmdi-account-circle field-icon"></span>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-input @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            placeholder="{{ __('adminlte::adminlte.email') }}" name="email" id="email"/>
                            <span class="zmdi zmdi-email field-icon"></span>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input @error('password') is-invalid @enderror"" name="password" id="password" 
                            placeholder="{{ __('adminlte::adminlte.password') }}"/>
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" id="password_confirmation" 
                            placeholder="{{ __('adminlte::adminlte.retype_password') }}"/>
                            <span toggle="#password_confirmation" class="zmdi zmdi-eye field-icon toggle-passwordC"></span>
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="{{ __('adminlte::adminlte.register') }}"/>
                            
                        </div>
                    </form>
                    <p class="loginhere">
                        Ya tienes cuenta? <a href="#" class="loginhere-link">Inicia sesion</a>
                    </p>
                </div>
            </div>
        </section>

    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
    @section('adminlte_js')
        @stack('js')
        @yield('js')
    @stop
</body>
</html>
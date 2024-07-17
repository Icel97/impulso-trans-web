@extends('adminlte::page')

@section('title', 'Usuarios y Roles')

@section('content_header')
    <h1>Usuarios y Roles</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{$user->name}}</h3>
        </div>
        <div class="card-body">
            <h5 class="mb-3">Lista de usuarios</h5>
            {!! Form::model($user, ['route' => ['usuarios.update', $user], 'method' => 'PUT']) !!}
                @foreach ($roles as $rol)
                    <div>
                        <label>
                            {!! Form::checkbox('roles[]', $rol->id, $user->hasAnyRole($rol->id) ? : false, ['class' => 'mr-1']) !!}
                            {{$rol->name}}
                        </label>
                    </div>
                @endforeach
                {!! Form::submit('Asignar rol', ['class' => 'btn btn-primary mt-3']) !!}
            {!! Form::close() !!}
            
        </div> 
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
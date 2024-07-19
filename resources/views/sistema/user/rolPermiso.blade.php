@extends('adminlte::page')

@section('title', 'Roles y Permisos')

@section('content_header')
    <div class="d-flex justify-content-start">
        <a href="{{ route('roles.index') }}" class="btn btn-default mx-2"><i class="fas fa-arrow-left"></i></a>
        <h1>Roles y Permisos</h1>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{$role->name}}</h3>
        </div>
        <div class="card-body">
            <h5 class="mb-3">Lista de permisos</h5>
            {!! Form::model($role, ['route' => ['roles.asignarPermisos', $role], 'method' => 'PUT']) !!}
                @foreach ($permisos as $permiso)
                    <div>
                        <label>
                            {!! Form::checkbox('permisos[]', $permiso->id, $role->hasPermissionTo($permiso->id) ? : false, ['class' => 'mr-1']) !!}
                            {{$permiso->name}}
                        </label>
                    </div>
                @endforeach
                {!! Form::submit('Asignar permisos', ['class' => 'btn btn-primary mt-3']) !!}
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
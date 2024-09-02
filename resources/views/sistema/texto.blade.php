@extends('adminlte::page')

@section('title', 'Textos')

@section('content_header')
    <div class="d-flex justify-content-start mx-4">
        <h1>Textos de pagina web</h1>
    </div>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Programas</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('texts.update') }}" method="POST">
                @csrf
                @method('PUT')
                @foreach($programas as $text)
                <h5>{{ $text->identifier }}</h5>
                <div class="row">
                    <div class="form-group col-4">
                        <label for="title-{{ $text->id }}">Título</label>
                        <input type="text" class="form-control" id="title-{{ $text->id }}" name="texts[{{ $text->id }}][title]" value="{{ $text->title }}">
                    </div>
                    <div class="form-group col-8">
                        <label for="url_img-{{ $text->id }}">URL de la Imagen</label>
                        <input type="text" class="form-control" id="url_img-{{ $text->id }}" name="texts[{{ $text->id }}][url_img]" value="{{ $text->url_img }}">
                    </div>
                </div>
                    <div class="form-group">
                        <label for="content-{{ $text->id }}">Contenido</label>
                        <textarea class="form-control" id="content-{{ $text->id }}" name="texts[{{ $text->id }}][content]">{{ $text->content }}</textarea>
                    </div>
                    <hr>
                @endforeach
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
            });
        @endif
</script>
@stop
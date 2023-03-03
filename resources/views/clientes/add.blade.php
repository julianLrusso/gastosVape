@extends('layouts.main')

@section('title', 'Resumen general')

@section('main')
    <div class="container">

        <div class="card mt-4">
            <div class="card-body">
                <form action="{{route('clientes.create')}}" method="post">
                    @csrf

                    <label>Nombre: <input name="nombre" id="nombre" class="form-control" type="text"></label>
                    @error('nombre')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <label>Telefono: <input name="telefono" id="telefono" class="form-control" type="text"></label>
                    @error('telefono')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <label>Direccion: <input name="direccion" id="direccion" class="form-control" type="text"></label>
                    @error('direccion')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <div class="mt-3 d-flex justify-content-center">
                        <button class="btn btn-warning w-75">Agregar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

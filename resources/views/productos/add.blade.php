@extends('layouts.main')

@section('title', 'Resumen general')

@section('main')
    <div class="container">

        <div class="card mt-4">
            <div class="card-body">
                <form action="{{ route('productos.create') }}" method="post">
                    @csrf

                    <label>Nombre: <input name="nombre" id="nombre" class="form-control" type="text"></label>
                    @error('nombre')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label>Peso en gramos: <input class="form-control" type="text" name="peso" id="peso"></label>
                    @error('peso')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    {{--<label>Valor individual: <input class="form-control" type="text" name="precio" id="precio"></label>
                    @error('precio')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror--}}

                    <div class="mt-3 d-flex justify-content-center">
                        <button class="btn btn-warning w-75">Agregar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        const peso = document.getElementById('peso');
        peso.addEventListener('blur', () => {
            peso.value = peso.value.replace(',','.');
        })
    </script>
@endsection

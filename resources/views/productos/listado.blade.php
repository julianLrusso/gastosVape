@extends('layouts.main')

@section('title', 'Listado de productos')

@section('main')
    <div class="container">

        <a href="{{route('productos.agregar')}}">
            <button class="btn btn-warning w-100 mt-2">Agregar producto</button>
        </a>

        <div class="row justify-content-center mt-1">
            @foreach($productos as $producto)
            <div class="card col-lg-3 m-2 @if($producto->trashed()) bg-danger @endif">
                <a href="{{ route('productos.show', ['id' => $producto->id]) }}" style="text-decoration: none; color: black">
                    <div class="card-body @if($producto->trashed()) text-white @endif">
                        <p> {{ $producto->nombre }} </p>
                        <p>Stock: {{ $producto->stock }}</p>
                    </div>
                </a>
            </div>
            @endforeach

        </div>

    </div>
@endsection

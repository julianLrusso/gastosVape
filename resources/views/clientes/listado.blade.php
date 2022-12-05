@extends('layouts.main')

@section('title', 'Resumen general')

@section('main')
    <div class="container">

        <a href="{{route('clientes.agregar')}}">
            <button class="btn btn-warning w-100 mt-2">Agregar Cliente</button>
        </a>

        <div class="row justify-content-center mt-1">
            @foreach($clientes as $cliente)
                <div class="card col-lg-3 m-2 @if($cliente->trashed()) bg-danger @endif">
                    <a href="{{ route('clientes.show', ['id' => $cliente->id]) }}" style="text-decoration: none; color: black">
                        <div class="card-body @if($cliente->trashed()) text-white @endif">
                            <p> {{ $cliente->nombre }} </p>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>

    </div>
@endsection

@extends('layouts.main')

@section('title', 'Resumen general')

@section('main')

    <div class="mt-1 container">

        <a href="{{route('formRegister')}}">
            <button class="btn btn-warning w-100 mt-2">Registrar Usuario</button>
        </a>

        <div class="card mt-2 mb-4">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Usuario</th>
                        <th scope="col">Acciones</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($usuarios as $usuario)
                        <tr>
                            <th>{{ $usuario->email }}</th>
                            <td>
                                <a href="{{route('usuarios.changeForm', ['id' => $usuario->id]) }}">
                                    <button class="btn btn-warning">Cambiar contraseña</button>
                                </a>
                            </td>
                            <td>
                                <form action="{{route('usuarios.eraseUsuario')}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="idUsuario" value="{{$usuario->id}}">
                                    <button class="btn btn-danger">Eliminar</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

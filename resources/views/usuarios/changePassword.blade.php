@extends('layouts.main')

@section('title', 'Cambiar contraseña')

@section('main')
    <form action="{{route('usuarios.changePassword')}}" method="POST">
        @csrf
        <div class="container">
            <div class="row align-items-center">
                <div class="card col">
                    <div class="card-body">

                        <div class="form-group">
                            <p>Usuario:</p>
                            <input type="hidden" value="{{$usuario->id}}" name="idUsuario">
                            <p>{{$usuario->email}}</p>
                        </div>

                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password">
                            @error('password')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Repetir contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-warning w-100 mt-3">Cambiar contraseña</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

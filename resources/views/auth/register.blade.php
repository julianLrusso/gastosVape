@extends('layouts.main')

@section('title', 'Resumen general')

@section('main')
    <form action="{{route('register')}}" method="POST">
        @csrf
        <div class="container">
            <div class="row align-items-center">
                <div class="card col">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
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

                        <button type="submit" class="btn btn-warning w-100 mt-3">Registrar usuario</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body style="background-color: #2a268f">
<main style="height: 100vh">

    @if(Session::has('message.success'))
        <div class="alert alert-success container my-3">
            {!! Session::get('message.success') !!}
        </div>
    @endif
    @if(Session::has('message.error'))
        <div class="alert alert-danger container my-3">
            {!! Session::get('message.error') !!}
        </div>
    @endif

    <form action="{{'login'}}" method="POST">
        @csrf
        <div class="container" style="height: 100vh">
            <div class="row align-items-center" style="height: 100vh">
                <div class="card col">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">Usuario</label>
                            <input type="text" class="form-control" id="email" name="email"
                                   aria-describedby="emailHelp">
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

                        <button type="submit" class="btn btn-warning w-100 mt-3">Ingresar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>
</body>
</html>

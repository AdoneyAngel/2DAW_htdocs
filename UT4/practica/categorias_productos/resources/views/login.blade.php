<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="token" content="{{csrf_token()}}">
    <title>Login</title>
</head>
<body>
    @isset($error)
        <p style="color:red">{{$error}}</p>
    @endisset

    <form action="{{route("login")}}" method="POST">
        @csrf
        <h1>Login</h1>
        <input type="text" name="usuario">
        <input type="text" name="clave">
        <button>Login</button>
    </form>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">

<h1 class="text-center mt-3">Login</h1>

@if(Session::has('error'))
<h3 class="text-danger">{{Session::get('error')}}</h3>
@endif
<form method="Post" action="/login">
    @csrf
    <label for="email">Email: </label>
    <input type="text" name="email" value="{{ old('email') }}">
    @if($errors->has('email'))
    <div class="text-danger">{{ $errors->first('email') }}</div>
@endif
    <br><br>

    <label for="password">Password: </label>
    <input type="password" name="password">
    @if($errors->has('password'))
    <div class="text-danger">{{ $errors->first('password') }}</div>
@endif

    <br>
    <button class="btn btn-primary">Submit</button>

</form>
</div>
    
</body>
</html>
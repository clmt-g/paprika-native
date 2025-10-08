<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
{{ $age }}<br>
{{ $nom }}<br>
{{ $tels['home'] }}<br>
@if($age == 15)
<p>L'age est 15</p>
@endif
@foreach ( $tels as $type => $numero)
<span> {{ $type }} <br> {{ $numero }} </span>
@endforeach
<span style="color: {{ $couleur }}">Test</span>

</body>
</html>

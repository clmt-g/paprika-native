<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Test Paprika</title>
</head>
<body>

<h1>Infos utilisateur</h1>
<p>Nom : {{ $nom }}</p>
<p>Age : {{ $age }}</p>
<p>Couleur : <span style="color: {{ $couleur }}">{{ $couleur }}</span></p>
<p>Examplediv : {{ $examplediv }}</p>
<p>Compteur : {{ $compteur }}</p>

<h2>Numéros de téléphone</h2>
@foreach ($tel as $type => $numero)
<p>{{ $type }} : {{ $numero }}</p>
@endforeach

</body>
</html>
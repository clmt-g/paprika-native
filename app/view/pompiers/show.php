<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>show</title>
</head>
<body>
<table>
    <tr>
        <th>N°</th>
        <th>Matricule</th>
        <th>Prenom</th>
        <th>Nom</th>
        <th>Chef d'agré</th>
        <th>Date de naissance</th>
        <th>Caserne</th>
        <th>Grade</th>
        <th>Matricule Responsable</th>
    </tr>
    @foreach ( $pompiers as $pompier )
    <tr>
        <td> {{ $i++ }}</td>
        <td> {{ $pompier->getMatricule() }} </td>
        <td> {{ $pompier->getPrenom() }} </td>
        <td> {{ $pompier->getNom() }} </td>
        <td> {{ $pompier->getChefAgret() }} </td>
        <td> {{ $pompier->getDateNaissance() }}</td>
        <td> {{ $pompier->getNumCaserne() }}</td>
        <td> {{ $pompier->getCodeGrade() }} </td>
        <td> {{ $pompier->getMatriculeRespo() }} </td>
        <td> delete / update / detail </td>
    </tr>
    @endforeach
</table>
</body>
</html>
// FIXME : afficher nom de caserne + ajouter grade + quand on sur la caserne, affiche la caserne

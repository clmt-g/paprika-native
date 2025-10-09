<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>detail</title>
</head>
<body>
</body>
    <form action="" method="post">
        <label for="matricule">Matricule</label>
        <input type="text" id="matricule" name="matricule" value="{{ $pompier->getMatricule() }}"  disabled required>

        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" value="{{ $pompier->getPrenom() }}" disabled required>

        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="{{ $pompier->getNom() }}" disabled required>

        <label for="chefAgret">Chef d’agrès</label>
        <select id="chefAgret" name="chefAgret_display" disabled>
            <option value="0" {{ $pompier->getChefAgret() == 0 ? 'selected' : '' }}>Non</option>
            <option value="1" {{ $pompier->getChefAgret() == 1 ? 'selected' : '' }}>Oui</option>
        </select>

        <!-- Champ caché pour envoyer la vraie valeur -->
        <input type="hidden" name="chefAgret" value="{{ $pompier->getChefAgret() }}">

        <label for="dateNaissance">Date de naissance</label>
        <input type="date" id="dateNaissance" name="dateNaissance" value="{{ $pompier->getDateNaissance() }}" disabled required>

        <label for="numCaserne">Numéro de caserne</label>
        <input type="number" id="numCaserne" name="numCaserne" min="1" value="{{ $pompier->getNumCaserne() }}" disabled required>

        <label for="codeGrade">Code grade</label>
        <input type="text" id="codeGrade" name="codeGrade" value="{{ $pompier->getCodeGrade() }}" disabled required>

        <label for="matriculeRespo">Matricule du responsable</label>
        <input type="text" id="matriculeRespo" name="matriculeRespo" value="{{ $pompier->getMatriculeRespo() }}" disabled required>
    </form>
</html>

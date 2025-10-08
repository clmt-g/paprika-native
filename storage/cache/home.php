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
<p>Nom : <?php echo $nom; ?></p>
<p>Age : <?php echo $age; ?></p>
<p>Couleur : <span style="color: <?php echo $couleur; ?>"><?php echo $couleur; ?></span></p>
<p>Examplediv : <?php echo $examplediv; ?></p>
<p>Compteur : <?php echo $compteur; ?></p>

<h2>Numéros de téléphone</h2>
<?php foreach ($tel as $type => $numero): ?>
<p><?php echo $type; ?> : <?php echo $numero; ?></p>
<?php endforeach; ?>



</body>
</html>
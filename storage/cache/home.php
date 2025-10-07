<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php echo $nom; ?> <?php echo $age; ?>

<?php foreach ($tel as $type => $numero): ?>

<span><?php echo $type; ?>  <?php echo $numero; ?></span>

<?php endforeach; ?>


</body>
</html>
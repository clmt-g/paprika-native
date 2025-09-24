<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../vendor/autoload.php";



$pdo1 = \Paprika\utils\SingletonDataBaseMariaDB::getInstance()->getPdo();
$pdo2 = \Paprika\utils\SingletonDataBaseMariaDB::getInstance()->getPdo();
assert($pdo1 ==$pdo2); //ajouter "assertion:"
dd($pdo1);



die();
//echo "Hello world";

// $c = new \Paprika\Dummy();

// $c->greeting();


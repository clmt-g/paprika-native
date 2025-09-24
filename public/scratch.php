<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "../vendor/autoload.php";



$pdo1 = \Paprika\Utils\SingletonDataBaseMariaDB::getInstance()->getPdo();
$pdo2 = \Paprika\Utils\SingletonDataBaseMariaDB::getInstance()->getPdo();
assert($pdo1 == $pdo2);
dd($pdo1);



die();
//echo "Hello world";

// $c = new \Paprika\Dummy();

// $c->greeting();


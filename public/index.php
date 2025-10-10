<?php

require_once '../vendor/autoload.php';

use \Paprika\controller\DefaultController;
use \Paprika\controller\CaserneController;

if (isset($_SERVER["PATH_INFO"])) {
    $path = trim($_SERVER["PATH_INFO"], "/");
} else {
    $path = "";
}

$fragments = explode("/", $path);
$control = array_shift($fragments);

switch ($control) {
    case '':
        defaultRoutes_get($fragments);
        break;

    case "pompier":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            pompierRoutes_get($fragments);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            pompierRoutes_post($fragments);
        }
        break;

    case "caserne":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            caserneRoutes_get($fragments);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            caserneRoutes_post($fragments);
        }
        break;

    default:
        header('Location: /404.html');
        break;
}

function defaultRoutes_get($fragments)
{
    call_user_func_array([new DefaultController(), "index"], $fragments);
}

/* --- ROUTES CASERNE --- */
function caserneRoutes_get($fragments)
{
    $action = array_shift($fragments);

    switch ($action) {
        case "show":
            // Vérifie si on a "detail" après show
            if (isset($fragments[0]) && $fragments[0] === "detail" && isset($fragments[1])) {
                $id = (int)$fragments[1];
                call_user_func_array([new \Paprika\controller\CaserneController(), "detail"], [$id]);
            } else {
                // Sinon, affiche la liste
                call_user_func_array([new \Paprika\controller\CaserneController(), "show"], $fragments);
            }
            break;

        case "add":
            call_user_func_array([new \Paprika\controller\CaserneController(), "create"], $fragments);
            break;

        case "update":
            call_user_func_array([new \Paprika\controller\CaserneController(), "update"], $fragments);
            break;

        case "delete":
            call_user_func_array([new \Paprika\controller\CaserneController(), "delete"], $fragments);
            break;

        default:
            echo "Action '$action' non définie <hr>";
            break;
    }
}

function caserneRoutes_post($fragments)
{
    $action = array_shift($fragments);

    switch ($action) {
        case "add":
            echo call_user_func_array([new CaserneController(), "do_create"], [$_POST]);
            break;

        case "update":
            echo call_user_func_array([new CaserneController(), "do_update"], [$_POST]);
            break;

        case "delete":
            echo call_user_func_array([new CaserneController(), "do_delete"], [$_POST['id'] ?? null]);
            break;

        default:
            echo "Action '$action' non définie <hr>";
            break;
    }
}


function pompierRoutes_get($fragments)
{
    $action = array_shift($fragments);
    switch ($action) {
        case "affiche":
            call_user_func_array([new PompierController(), "showAll"], $fragments);
            break;
        case "demo":
            call_user_func_array(["PompierController", "demo_test"], $fragments);
            break;
        case "delete":
            call_user_func_array([new \app\controllers\PompierController(), "delete"], $fragments);
            break;
        case "edit":
            call_user_func_array([new \app\controllers\PompierController(), "edit"], $fragments);
            break;
        default:
            echo "Action '$action' non définie <hr>";
            break;
    }
}

function pompierRoutes_post($fragments)
{
    $action = array_shift($fragments);
    switch ($action) {
        case "delete":
            call_user_func_array([new \app\controllers\PompierController(), "do_delete"], $fragments);
            break;
        case "update":
            call_user_func_array([new \app\controllers\PompierController(), "update"], $fragments);
            break;
        default:
            echo "Action '$action' non définie <hr>";
            break;
    }
}
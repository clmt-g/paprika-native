<?php

require_once '../vendor/autoload.php';

use \Paprika\controller\DefaultController;
use \Paprika\controller\CaserneController;
use \Paprika\controller\PompiersController;

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

    case "pompiers":
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
        header('Location: /404.php');
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
                echo call_user_func_array([new \Paprika\controller\CaserneController(), "detail"], [$id]);
            } else {
                // Sinon, affiche la liste
                echo call_user_func_array([new \Paprika\controller\CaserneController(), "show"], $fragments);
            }
            break;

        case "add":
            echo call_user_func_array([new \Paprika\controller\CaserneController(), "create"], $fragments);
            break;

        case "update":
            echo call_user_func_array([new \Paprika\controller\CaserneController(), "update"], $fragments);
            break;

        case "delete":
            echo call_user_func_array([new \Paprika\controller\CaserneController(), "delete"], $fragments);
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

    //var_dump($fragment);

    $action = array_shift($fragments);
    //var_dump($action);

    switch ($action) {
        case "show":
            // Vérifie si on a "detail" après show
            if (isset($fragments[0]) && $fragments[0] === "detail" && isset($fragments[1])) {
                $id = $fragments[1];
                echo call_user_func_array([new \Paprika\controller\PompiersController(), "detail"], [$id]);
            } else {
                // Sinon, affiche la liste
                echo call_user_func_array([new \Paprika\controller\PompiersController(), "show"], $fragments);
            }
            break;
        case "edit" :
        {
            //echo "Calling pompierController->del <hr>";
            call_user_func_array([new PompiersController(), "edit"], $fragments);
            break;
        }

        default :
        {
            echo "Action '$action' non defini <hr>";
            //Gestion du probleme
        }
    }
}

function pompierRoutes_post($fragments)
{

    $action = array_shift($fragments);
    switch ($action) {
        case "delete":
            //Access permission can be checked here too
            call_user_func_array([new PompiersController(), "do_delete"], $fragments);
            break;
        case "update" :
            //echo "Action '$action' ready <hr>";
            //Access permission can be checked here too
            call_user_func_array([new PompiersController(), "update"], $fragments);
            break;
        default:
            echo "Action '$action' non defini <hr>";
            break;
    }
}

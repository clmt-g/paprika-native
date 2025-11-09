<?php

require_once '../vendor/autoload.php';

use \Paprika\controller\DefaultController;
use \Paprika\controller\CaserneController;
use \Paprika\controller\PompiersController;

if (isset($_SERVER["REQUEST_URI"])) {
    $path = trim($_SERVER["REQUEST_URI"], "/");
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

    case "users":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            userRoutes_get($fragments);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            userRoutes_post($fragments);
        }
        break;

    default:
        header('Location: /error404.php');
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
        case "update" :
        {
            call_user_func_array([new PompiersController(), "update"], $fragments);
            break;
        }
        case "create" :
        {
            call_user_func_array([new PompiersController(), "create"], $fragments);
            break;
        }
        case "delete" :
        {
            call_user_func_array([new PompiersController(), "delete"], $fragments);
            break;
        }
        {
            echo "Action '$action' non defini <hr>";
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
            call_user_func_array([new PompiersController(), "do_update"], $fragments);
            break;
        case "create" :
            call_user_func_array([new PompiersController(), "do_create"], [null]);
            break;
        default:
            echo "Action '$action' non defini <hr>";
            break;
    }
}

function userRoutes_get($fragments)
{
    $action = array_shift($fragments);
    //var_dump($action);

    switch ($action) {
        case "show":
            // Vérifie si on a "detail" après show
            if (isset($fragments[0]) && $fragments[0] === "detail" && isset($fragments[1])) {
                $id = $fragments[1];
                echo call_user_func_array([new \Paprika\controller\UserController(), "detail"], [$id]);
            } else {
                // Sinon, affiche la liste
                echo call_user_func_array([new \Paprika\controller\UserController(), "show"], $fragments);
            }
            break;
        case "update" :
        {
            call_user_func_array([new \Paprika\controller\UserController(), "update"], $fragments);
            break;
        }
        case "create" :
        {
            call_user_func_array([new \Paprika\controller\UserController(), "create"], $fragments);
            break;
        }
        case "delete" :
            {
                call_user_func_array([new \Paprika\controller\UserController(), "delete"], $fragments);
                break;
            }
            {
                echo "Action '$action' non defini <hr>";
            }
    }
}

function userRoutes_post($fragments)
{
    $action = array_shift($fragments);
    switch ($action) {
        case "delete":
            //Access permission can be checked here too
            call_user_func_array([new \Paprika\controller\UserController(), "do_delete"], $fragments);
            break;
        case "update" :
            call_user_func_array([new \Paprika\controller\UserController(), "do_update"], $fragments);
            break;
        case "create" :
            call_user_func_array([new \Paprika\controller\UserController(), "do_create"], [null]);
            break;
        default:
            echo "Action '$action' non defini <hr>";
            break;
    }
}

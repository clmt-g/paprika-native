<?php

require_once '../vendor/autoload.php';

use Paprika\controller\DefaultController;
use Paprika\controller\CaserneController;
use Paprika\controller\PompiersController;

// Récupère le path
$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";
$fragments = explode("/", $path);
$control = array_shift($fragments);

// Routing principal
switch ($control) {
    case '':
        defaultRoutes_get($fragments);
        break;

    case "pompier":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            pompierRoutes_get($fragments);
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            pompierRoutes_post($fragments);
        }
        break;

    case "caserne":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            caserneRoutes_get($fragments);
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            caserneRoutes_post($fragments);
        }
        break;

    default:
        header('Location: /404.html');
        break;
}

// --- ROUTES PAR DÉFAUT ---
function defaultRoutes_get($fragments)
{
    call_user_func_array([new DefaultController(), "index"], $fragments);
}

// --- ROUTES CASERNE ---
function caserneRoutes_get($fragments)
{
    $action = array_shift($fragments);
    $controller = new CaserneController();

    switch ($action) {
        case "show":
            if (isset($fragments[0]) && $fragments[0] === "detail" && isset($fragments[1])) {
                call_user_func_array([$controller, "detail"], [(int)$fragments[1]]);
            } else {
                call_user_func_array([$controller, "show"], $fragments);
            }
            break;

        case "add":
            call_user_func_array([$controller, "create"], $fragments);
            break;

        case "update":
            call_user_func_array([$controller, "update"], $fragments);
            break;

        case "delete":
            call_user_func_array([$controller, "delete"], $fragments);
            break;

        default:
            echo "Action '$action' caserne non définie <hr>";
            break;
    }
}

function caserneRoutes_post($fragments)
{
    $action = array_shift($fragments);
    $controller = new CaserneController();

    switch ($action) {
        case "add":
            echo call_user_func_array([$controller, "do_create"], [$_POST]);
            break;

        case "update":
            echo call_user_func_array([$controller, "do_update"], [$_POST]);
            break;

        case "delete":
            echo call_user_func_array([$controller, "do_delete"], [$_POST['id'] ?? null]);
            break;

        default:
            echo "Action '$action' caserne non définie <hr>";
            break;
    }
}

// --- ROUTES POMPIER ---
function pompierRoutes_get($fragments)
{
    $action = array_shift($fragments);
    $controller = new PompiersController();

    switch ($action) {
        case "show":
            if (isset($fragments[0]) && $fragments[0] === "detail" && isset($fragments[1])) {
                call_user_func_array([$controller, "detail"], [$fragments[1]]);
            } else {
                call_user_func_array([$controller, "show"], $fragments);
            }
            break;

        case "edit":
            call_user_func_array([$controller, "edit"], $fragments);
            break;

        default:
            echo "Action '$action' pompier non définie <hr>";
            break;
    }
}

function pompierRoutes_post($fragments)
{
    $action = array_shift($fragments);
    $controller = new PompiersController();

    switch ($action) {
        case "update":
            call_user_func_array([$controller, "update"], $fragments);
            break;

        case "delete":
            call_user_func_array([$controller, "do_delete"], $fragments);
            break;

        default:
            echo "Action '$action' pompier non définie <hr>";
            break;
    }
}
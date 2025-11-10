<?php

require_once '../vendor/autoload.php';

use \Paprika\controller\DefaultController;
use \Paprika\controller\CaserneController;
use \Paprika\controller\PompiersController;
use Paprika\controller\AuthController;
use \Paprika\controller\UserController;

// Récupère le path
$path = $_SERVER["PATH_INFO"] ?? "";
$path = trim($path, "/");
$fragments = explode("/", $path);
$control = array_shift($fragments);

// Switch principal
switch ($control) {
    case '':
        defaultRoutes_get($fragments);
        break;

    /* --- ROUTES CASERNE --- */
    case "caserne":
        if ($_SERVER["REQUEST_METHOD"] === "GET") caserneRoutes_get($fragments);
        if ($_SERVER["REQUEST_METHOD"] === "POST") caserneRoutes_post($fragments);
        break;

    /* --- ROUTES POMPIERS --- */
    case "pompiers":
        if ($_SERVER["REQUEST_METHOD"] === "GET") pompierRoutes_get($fragments);
        if ($_SERVER["REQUEST_METHOD"] === "POST") pompierRoutes_post($fragments);
        break;

    /* --- ROUTES AUTH --- */
    case "login":
        $authController = new AuthController();
        if ($_SERVER["REQUEST_METHOD"] === "GET") $authController->loginForm();
        if ($_SERVER["REQUEST_METHOD"] === "POST") $authController->login();
        break;

    case "logout":
        $authController = new AuthController();
        $authController->logout();
        break;

    /* --- ROUTES USERS --- */
    case "users":
        $userController = new UserController();
        $action = array_shift($fragments) ?? "";

        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            switch ($action) {
                case "list": $userController->list(); break;
                case "add": $userController->addForm(); break;
                case "edit":
                    $id = $fragments[0] ?? null;
                    $userController->editForm($id);
                    break;
                default: echo "Action '$action' non définie"; break;
            }
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            switch ($action) {
                case "add": $userController->add(); break;
                case "edit":
                    $id = $fragments[0] ?? null;
                    $userController->edit($id);
                    break;
                case "delete":
                    $id = $fragments[0] ?? null;
                    $userController->delete($id);
                    break;
                default: echo "Action '$action' non définie"; break;
            }
        }
        break;

    /* --- ROUTES PAR DÉFAUT --- */
    default:
        header('Location: /error404.php');
        break;
}

/* --- Fonctions Caserne --- */
function caserneRoutes_get($fragments)
{
    $action = array_shift($fragments);
    $ctrl = new CaserneController();

    switch ($action) {
        case "show":
            if (isset($fragments[0]) && $fragments[0]==="detail" && isset($fragments[1])) {
                $ctrl->detail((int)$fragments[1]);
            } else {
                $ctrl->show($fragments);
            }
            break;
        case "add": $ctrl->create($fragments); break;
        case "update": $ctrl->update($fragments); break;
        case "delete": $ctrl->delete($fragments); break;
        default: echo "Action '$action' non définie"; break;
    }
}

function caserneRoutes_post($fragments)
{
    $action = array_shift($fragments);
    $ctrl = new CaserneController();

    switch ($action) {
        case "add": $ctrl->do_create($_POST); break;
        case "update": $ctrl->do_update($_POST); break;
        case "delete": $ctrl->do_delete($_POST['id'] ?? null); break;
        default: echo "Action '$action' non définie"; break;
    }
}

/* --- Fonctions Pompiers --- */
function pompierRoutes_get($fragments)
{
    $action = array_shift($fragments);
    $ctrl = new PompiersController();

    switch ($action) {
        case "show":
            if (isset($fragments[0]) && $fragments[0]==="detail" && isset($fragments[1])) {
                $ctrl->detail($fragments[1]);
            } else {
                $ctrl->show($fragments);
            }
            break;
        case "update": $ctrl->update($fragments); break;
        case "create": $ctrl->create($fragments); break;
        case "delete": $ctrl->delete($fragments); break;
        default: echo "Action '$action' non définie"; break;
    }
}

function pompierRoutes_post($fragments)
{
    $action = array_shift($fragments);
    $ctrl = new PompiersController();

    switch ($action) {
        case "delete": $ctrl->do_delete($fragments); break;
        case "update": $ctrl->do_update($fragments); break;
        case "create": $ctrl->do_create([null]); break;
        default: echo "Action '$action' non définie"; break;
    }
}

/* --- Default routes --- */
function defaultRoutes_get($fragments)
{
    call_user_func_array([new DefaultController(), "index"], $fragments);
}
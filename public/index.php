<?php

require_once '../vendor/autoload.php';

use \Paprika\controller\DefaultController;
use \Paprika\controller\CaserneController;
use \Paprika\controller\PompiersController;
use Paprika\controller\UserController;
use Paprika\controller\AuthController;
use Paprika\utils\Auth;

// ouvrir la session si besoin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SERVER["REQUEST_URI"])) {
    $path = trim($_SERVER["REQUEST_URI"], "/");
} else {
    $path = "";
}

$fragments = explode("/", $path);
$control = array_shift($fragments);

switch ($control) {
    case '':
        // Si pas connecté, rediriger vers login
        if (!Auth::isLogged()) {
            header('Location: /auth/login');
            exit;
        }
        // Si connecté, afficher la page d'accueil
        defaultRoutes_get($fragments);
        break;

    case "pompiers":
        // Vérifier si connecté avant d'accéder aux pompiers
        if (!Auth::isLogged()) {
            header('Location: /auth/login');
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            pompierRoutes_get($fragments);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            pompierRoutes_post($fragments);
        }
        break;

    case "caserne":
        // Vérifier si connecté avant d'accéder aux casernes
        if (!Auth::isLogged()) {
            header('Location: /auth/login');
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            caserneRoutes_get($fragments);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            caserneRoutes_post($fragments);
        }
        break;

    case "users":
        // Vérifier si connecté avant d'accéder aux users
        if (!Auth::isLogged()) {
            header('Location: /auth/login');
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            userRoutes_get($fragments);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            userRoutes_post($fragments);
        }
        break;

    case "auth":
        // Les routes auth sont accessibles sans connexion
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            authRoutes_get($fragments);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            authRoutes_post($fragments);
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
            if (Auth::can('caserne_save')) {
                echo call_user_func_array([new \Paprika\controller\CaserneController(), "create"], $fragments);
            } else {
                header ('Location: /error403.php');
                exit;
            }
            break;
        case "update":
            if (Auth::can('caserne_update')) {
                echo call_user_func_array([new \Paprika\controller\CaserneController(), "update"], $fragments);
            } else {
                header ('Location: /error403.php');
                exit;
            }
            break;
        case "delete":
            if (Auth::can('caserne_delete')) {
                echo call_user_func_array([new \Paprika\controller\CaserneController(), "delete"], $fragments);
            } else {
                header ('Location: /error403.php');
                exit;
            }
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
            if (Auth::can('caserne_save')) {
                echo call_user_func_array([new CaserneController(), "do_create"], [$_POST]);
            } else {
                header ('Location: /error403.php');
                exit;
            }
            break;

        case "update":
            if (Auth::can('caserne_update')) {
                echo call_user_func_array([new CaserneController(), "do_update"], [$_POST]);
            } else {
                header ('Location: /error403.php');
                exit;
            }
            break;

        case "delete":
            if (Auth::can('caserne_delete')) {
                echo call_user_func_array([new CaserneController(), "do_delete"], [$_POST['id'] ?? null]);
            } else {
                header ('Location: /error403.php');
                exit;
            }
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
            if (Auth::can('pompier_update')) {
                call_user_func_array([new PompiersController(), "update"], $fragments);
            } else {
                header ('Location: /error403.php');
                exit;
            }
            break;
        }
        case "create" :
        {
            if (Auth::can('pompier_save')) {
                call_user_func_array([new PompiersController(), "create"], $fragments);
            } else {
                header ('Location: /error403.php');
                exit;
            }
            break;
        }
        case "delete" :
        {
            if (Auth::can('pompier_delete')) {
                call_user_func_array([new PompiersController(), "delete"], $fragments);
            } else {
                header ('Location: /error403.php');
                exit;
            }
            break;
        }
        default:
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
            if (Auth::can('pompier_delete')) {
                call_user_func_array([new PompiersController(), "do_delete"], $fragments);
            } else {
                header ('Location: /error403.php');
                exit;
            }
            break;
        case "update" :
            if (Auth::can('pompier_update')) {
                call_user_func_array([new PompiersController(), "do_update"], $fragments);
            } else {
                header ('Location: /error403.php');
                exit;
            }
            break;
        case "create" :
            if (Auth::can('pompier_save')) {
                call_user_func_array([new PompiersController(), "do_create"], [null]);
            } else {
                header ('Location: /error403.php');
                exit;
            }
            break;
        default:
            echo "Action '$action' non defini <hr>";
            break;
    }
}

function userRoutes_get($fragments)
{
    $action = array_shift($fragments);

    switch ($action) {
        case "show":
            // Vérifie si on a "detail" après show
            if (isset($fragments[0]) && $fragments[0] === "detail" && isset($fragments[1])) {
                $id = (int)$fragments[1];
                $currentUserId = $_SESSION['auth']['id'] ?? null;

                // Autoriser si admin OU si c'est son propre profil
                if (Auth::can('user_show') || $id === $currentUserId) {
                    echo call_user_func_array([new \Paprika\controller\UserController(), "detail"], [$id]);
                } else {
                    header('Location: /error403.php');
                    exit;
                }
            } else {
                // Liste des users : uniquement admin
                if (Auth::can('user_show')) {
                    echo call_user_func_array([new \Paprika\controller\UserController(), "show"], $fragments);
                } else {
                    header('Location: /error403.php');
                    exit;
                }
            }
            break;
        case "update" :
        {
            if (Auth::can('user_update')) {
                call_user_func_array([new \Paprika\controller\UserController(), "update"], $fragments);
            } else {
                header ('Location: /error403.php');
                exit;
            }
            break;
        }
        case "create" :
        {
            if (Auth::can('user_save')) {
                call_user_func_array([new \Paprika\controller\UserController(), "create"], $fragments);
            } else {
                header ('Location: /error403.php');
                exit;
            }
            break;
        }
        case "update-password":
        {
            // Récupérer l'ID depuis les fragments
            $userId = isset($fragments[0]) ? (int)$fragments[0] : null;
            $currentUserId = $_SESSION['auth']['id'] ?? null;

            // Autoriser si admin OU si c'est son propre mot de passe
            if (Auth::can('user_update') || $userId === $currentUserId) {
                call_user_func_array([new \Paprika\controller\UserController(), "updatePasswd"], $fragments);
            } else {
                header('Location: /error403.php');
                exit;
            }
            break;
        }
        case "delete" :
        {
            if (Auth::can('user_delete')) {
                call_user_func_array([new \Paprika\controller\UserController(), "delete"], $fragments);
            } else {
                header ('Location: /error403.php');
                exit;
            }
            break;
        }
        default:
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
            if (Auth::can('user_delete')) {
                call_user_func_array([new \Paprika\controller\UserController(), "do_delete"], $fragments);
            } else {
                header ('Location: /error403.php');
                exit;
            }
            break;
        case "update" :
            if (Auth::can('user_update')) {
                call_user_func_array([new \Paprika\controller\UserController(), "do_update"], $fragments);
            } else {
                header ('Location: /error403.php');
                exit;
            }
            break;
        case "create" :
            if (Auth::can('user_save')) {
                call_user_func_array([new \Paprika\controller\UserController(), "do_create"], [null]);
            } else {
                header ('Location: /error403.php');
                exit;
            }
            break;
        case "update-password":
        {
            // Récupérer l'ID depuis POST ou fragments
            $userId = isset($_POST['id']) ? (int)$_POST['id'] : (isset($fragments[0]) ? (int)$fragments[0] : null);
            $currentUserId = $_SESSION['auth']['id'] ?? null;

            // Autoriser si admin OU si c'est son propre mot de passe
            if (Auth::can('user_update') || $userId === $currentUserId) {
                call_user_func_array([new \Paprika\controller\UserController(), "do_updatePasswd"], $fragments);
            } else {
                header('Location: /error/403');
                exit;
            }
            break;
        }
        default:
            echo "Action '$action' non defini <hr>";
            break;
    }
}

function authRoutes_get($fragments) {
    $action = array_shift($fragments);

    // Si l'action est vide et qu'on est sur /auth, rediriger vers /auth/login
    if (empty($action)) {
        $action = "login";
    }

    switch ($action) {
        case "login":
            // Si déjà connecté, rediriger vers l'accueil
            if (Auth::isLogged()) {
                header('Location: /');
                exit;
            }
            call_user_func_array([new \Paprika\controller\AuthController(), "login"], $fragments);
            break;
        case "logout":
            call_user_func_array([new \Paprika\controller\AuthController(), "logout"], $fragments);
            break;
        default:
            echo "Action '$action' non defini <hr>";
            break;
    }
}

function authRoutes_post($fragments) {
    $action = array_shift($fragments);
    switch ($action) {
        case "login":
            call_user_func_array([new \Paprika\controller\AuthController(), "do_login"], $fragments);
            break;
        case "logout":
            call_user_func_array([new \Paprika\controller\AuthController(), "do_logout"], $fragments);
            break;
        default:
            echo "Action '$action' non defini <hr>";
            break;
    }
}
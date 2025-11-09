<?php

namespace Paprika\controller;

/* use to display the infos of the user */

use Paprika\model\DAOUser;
use Paprika\model\User;
use Paprika\utils\CSRFToken;
use Paprika\utils\CSRFTokenSession;
use Paprika\utils\Filtre;
use Paprika\utils\Renderer;
use Paprika\utils\SingletonDataBaseMariaDB;
use Paprika\utils\validators\MailValidator;
use Paprika\utils\validators\NameValidator;
use Paprika\utils\validators\PasswordValidator;
use Paprika\utils\validators\RoleValidator;
use Random\RandomException;

class UserController extends BaseController
{
    private DAOUser $userDAO;
    private static CSRFToken $csrftoken;

    public function __construct() {
        $this->userDAO = new DAOUser(SingletonDataBaseMariaDB::getInstance()->getLoggedPDO());
        self::$csrftoken = new CSRFTokenSession();
    }

    /** display the show page
     * @return void
     */
    public function show(): void
    {
        $users = $this->userDAO->findAll();
        if (!$users) {
            header("location: /404.php");
            exit;
        }
        $compteur = 1;
        echo Renderer::render('users/show', ['users' => $users, 'compteur' => $compteur]);
    }

    /**
     * @param $id
     * @return void
     * @throws \Exception
     */
    public function detail($id): void
    {
        $user = $this->userDAO->find($id);
        if (!$user) {
            header("location: /404.php");
        }
        echo Renderer::render('users/detail', ['user' => $user]);
    }

    /** display the create page
     * @return void
     * @throws RandomException
     */
    public function create(): void
    {
        // générer le cookie pour le passer à la vue
        $token = self::$csrftoken::generateToken();
        if (!$token) {
            $errors[] = "Erreur lors de la génération du token";
            echo Renderer::render('pompiers/error',
                ['errors' => $errors, 'type' => 'create']
            );
            return;
        }
        echo Renderer::render('users/create', ['token' => $token]);
    }

    public function do_create($data): void
    {
        $errors = [];

        // récupérer le cookie pour vérifier sa validité
        $token = $_POST['token'] ?? null;
        if (!self::$csrftoken::check($token)) {
            $errors[] = "Le token est expiré ou invalide";
            echo Renderer::render('users/error',
                ['errors' => $errors]
            );
            return;
        }

        // vérifier la validité des données
        $data = [
            'nom' => $_POST['nom'] ?? null,
            'prenom' => $_POST['prenom'] ?? null,
            'login' => $_POST['login'] ?? null,
            'passwd' => $_POST['passwd'] ?? null,
            'role' => $_POST['role'] ?? null
        ];

        $result = $this->verifyData($data);

        if (!$result['valid']) {
            echo Renderer::render('users/error',
                ['errors' => $result['errors']]
            );
            return;
        }
        $cleanData = $result['data'];

        // haché le mot de passe
        $cleanData['passwd'] = password_hash($cleanData['passwd'], PASSWORD_DEFAULT);

        $user = new User($cleanData['nom'], $cleanData['prenom'], $cleanData['login'], $cleanData['passwd'], $cleanData['role']);
        $this->userDAO->save($user);
        $matricule = $user->getId();

        header("location: /users/show/detail/" . $matricule);
        exit;
    }

    public function update($id): void
    {
        // TODO: Implement update() method.
    }

    public function do_update($data): void
    {
        // TODO: Implement do_update() method.
    }

    public function delete($id): void
    {
        // TODO: Implement delete() method.
    }

    public function do_delete($id): void
    {
        // TODO: Implement do_delete() method.
    }

    public function resetPasswd($id): void {

    }

    private function verifyData($data): array {
        $errors = [];

        // --- Configuration du filtre ---
        $filtre = new Filtre();
        $filtre->addValidator('nom', new NameValidator());
        $filtre->addValidator('prenom', new NameValidator());
        $filtre->addValidator('login', new MailValidator());
        $filtre->addValidator('passwd', new PasswordValidator());
        $filtre->addValidator('role', new RoleValidator());
        // --- Exécution de la validation ---
        $result = $filtre->execute($data);

        // --- Collecte des erreurs depuis le filtre ---
        foreach ($result as $field => $isValid) {
            if (!$isValid) {
                $errors[] = $this->getErrorMessage($field);
            }
        }

        // --- Retour ---
        if (!empty($errors)) {
            return ['valid' => false, 'errors' => $errors, 'data' => null];
        }

        return [
            'valid' => true,
            'errors' => [],
            'data' => [
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'login' => $data['login'],
                'passwd' => $data['passwd'],
                'role' => $data['role']
            ]
        ];
    }

    /**
     * Retourne un message d'erreur personnalisé pour chaque champ
     */
    private function getErrorMessage(string $field): string
    {
        $messages = [
            'nom' => 'Le nom est invalide',
            'prenom' => 'Le prénom est invalide',
            'email' => "L'adresse mail est invalide",
            'passwd' => "Le mot de passe est invalide",
            'role' => 'Le role est invalide'
        ];

        return $messages[$field] ?? "Le champ '$field' est invalide";
    }
}
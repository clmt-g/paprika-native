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
use Paprika\utils\Auth;

class UserController extends BaseController
{
    private DAOUser $userDAO;
    private static CSRFToken $csrftoken;

    public function __construct() {
        parent::__construct();
        $this->userDAO = new DAOUser(SingletonDataBaseMariaDB::getInstance()->getLoggedPDO());
        self::$csrftoken = new CSRFTokenSession();
    }

    /** display the show page
     * @return void
     */
    public function show(): void
    {
        // controlle d'accès
        if(!Auth::can("user_show")) {
            header('Location: /error403.php');
            exit;
        }
        // récupérer le message flash s'il existe (en cas de modification du mot de passe)
        $successMessage = $_SESSION['success_message'] ?? null;
        $showSuccessMessage = !empty($successMessage); // vrai si message existant
        unset($_SESSION['success_message']); // supprime le message pour ne pas le réafficher

        $users = $this->userDAO->findAll();
        if (!$users) {
            header("location: /error404.php");
            exit;
        }
        $compteur = 1;
        echo Renderer::render('users/show', ['users' => $users, 'compteur' => $compteur, 'showSuccessMessage' => $showSuccessMessage, 'successMessage' => $successMessage]);
    }

    /**
     * @param $id
     * @return void
     * @throws \Exception
     */
    public function detail($id): void
    {
        $currentUserId = $_SESSION['auth']['id'] ?? null;
        // controlle d'accès : Autoriser si admin OU si c'est son propre profil
        if (!Auth::can('user_show') && $id !== $currentUserId) {
            header('Location: /error403.php');
            exit;
        }

        $user = $this->userDAO->find($id);
        if (!$user) {
            header("location: /error404.php");
        }
        echo Renderer::render('users/detail', ['user' => $user]);
    }

    /** display the create page
     * @return void
     * @throws RandomException
     */
    public function create(): void
    {
        // controlle d'accès
        if(!Auth::can("user_create")) {
            header('Location: /error403.php');
            exit;
        }

        // générer le token pour le passer à la vue
        $token = self::$csrftoken::generateToken();
        if (!$token) {
            $errors[] = "Erreur lors de la génération du token";
            echo Renderer::render('pompiers/error',
                ['errors' => $errors]
            );
            return;
        }
        echo Renderer::render('users/create', ['token' => $token]);
    }

    /** insert the user in the database if the data is valid
     * @param $data
     * @return void
     * @throws \Exception
     */
    public function do_create($data): void
    {
        // controlle d'accès
        if(!Auth::can("user_create")) {
            header('Location: /error403.php');
            exit;
        }

        $errors = [];

        // récupérer le token pour vérifier sa validité
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

        $result = $this->verifyData($data, true);

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

    /** display the update page
     * @param $id
     * @return void
     * @throws RandomException
     * @throws \Exception
     */
    public function update($id): void
    {
        // controlle d'accès
        if(!Auth::can("user_update")) {
            header('Location: /error403.php');
            exit;
        }

        // générer le token pour le passer à la vue
        $token = self::$csrftoken::generateToken();
        if (!$token) {
            $errors[] = "Erreur lors de la génération du token";
            echo Renderer::render('pompiers/error',
                ['errors' => $errors, 'type' => 'create']
            );
            return;
        }
        // récuprer le user
        $user = $this->userDAO->find($id);
        if (!$user) {
            header("location: /404.php");
            exit;
        }
        echo Renderer::render('users/update', ['user' => $user, 'token' => $token]);
    }


    /** update the user
     * @param $data
     * @return void
     * @throws \Exception
     */
    public function do_update($data): void
    {
        // controlle d'accès
        if(!Auth::can("user_update")) {
            header('Location: /error403.php');
            exit;
        }

        // récupérer le token et vérifier si il est valide
        $errors = [];

        $token = $_POST['token'] ?? null;
        if (!self::$csrftoken::check($token)) {
            $errors[] = "Le token est expiré ou invalide";
            echo Renderer::render('users/error',
                ['errors' => $errors]
            );
            return;
        }

        // désinfecter les données
        $data = [
            'nom' => $_POST['nom'] ?? null,
            'prenom' => $_POST['prenom'] ?? null,
            'login' => $_POST['login'] ?? null,
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

        // enregistrement des modifications
        $id = $_POST['id'] ?? null;
        // NE PAS hasher si passwd est null ou vide
        if (!empty($cleanData['passwd'])) {
            $cleanData['passwd'] = password_hash($cleanData['passwd'], PASSWORD_BCRYPT);
        } else {
            // Récupérer l'ancien password depuis la BDD
            $existingUser = $this->userDAO->find($id);
            $cleanData['passwd'] = $existingUser->getPasswd();
        }

        $user = new User($cleanData['nom'], $cleanData['prenom'], $cleanData['login'], $cleanData['passwd'] , $cleanData['role'], false, $id);
        // redirection
        if ($this->userDAO->update($user)) {
            header("location: /users/show/detail/" . $user->getId());
            exit;
        } else {
            $errors[] = "erreur lors de la mise à jour de l'utilisateur";
            echo Renderer::render("users/error", ['errors' => $errors]);
            return;
        }
    }

    /** display the delete modal
     * @param $id
     * @return void
     * @throws \Exception
     */
    public function delete($id): void
    {
        // controlle d'accès
        if(!Auth::can("user_delete")) {
            header('Location: /error403.php');
            exit;
        }

        $user = $this->userDAO->find($id);
        if (!$user) {
            header("location: /404.php");
            exit;
        }
        echo Renderer::render('users/delete', ['user' => $user]);
    }

    /** delete a user
     * @param $id
     * @return void
     * @throws \Exception
     */
    public function do_delete($id): void
    {
        // controlle d'accès
        if(!Auth::can("user_delete")) {
            header('Location: /error403.php');
            exit;
        }

        $errors = [];

        // vérifier que l'utilisateur existe
        $user = $this->userDAO->find($id);
        if (!$user) {
            $errors[] = "L'utilisateur avec l'identifiant $id n'existe pas.";
            echo Renderer::render('users/error', ['errors' => $errors]);
            return;
        }

        // suppression
        if ($this->userDAO->delete($user)) {
            header("location: /users/show");
        } else {
            $errors[] = "Erreur lors de la suppression de l'utilisateur";
            echo Renderer::render("/users/error", ['errors' => $errors]);
        }
    }

    /** display the update-password page
     * @param $id
     * @return void
     * @throws \Exception
     */
    public function updatePasswd($id): void {
        $currentUserId = $_SESSION['auth']['id'] ?? null;
        // controlle d'accès : Autoriser si admin OU si c'est son propre profil
        if (!Auth::can('user_update') && $id !== $currentUserId) {
            header('Location: /error403.php');
            exit;
        }

        // générer le token pour le passer à la vue
        $token = self::$csrftoken::generateToken();
        if (!$token) {
            $errors[] = "Erreur lors de la génération du token";
            echo Renderer::render('pompiers/error',
                ['errors' => $errors, 'type' => 'create']
            );
            return;
        }

        $user = $this->userDAO->find($id);
        if (!$user) {
            $errors[] = "L'utilisateur avec l'identifiant $id n'existe pas.";
            echo Renderer::render('users/error', ['errors' => $errors]);
            return;
        }
        echo Renderer::render('users/update-password', ['user' => $user, 'token' => $token]);
    }

    /** reset the password
     * @param $id
     * @return void
     * @throws \Exception
     */
    public function do_updatePasswd($id): void {
        $currentUserId = $_SESSION['auth']['id'] ?? null;
        // controlle d'accès : Autoriser si admin OU si c'est son propre profil
        if (!Auth::can('user_update') && $id !== $currentUserId) {
            header('Location: /error403.php');
            exit;
        }

        $errors = [];

        // récupérer le token et vérifier si il est valide
        $token = $_POST['token'] ?? null;
        if (!self::$csrftoken::check($token)) {
            $errors[] = "Le token est expiré ou invalide";
            echo Renderer::render('users/error',
                ['errors' => $errors]
            );
            return;
        }

        // vérifier si l'ancien mot de passe correspond
        $form_old_passwd = trim($_POST['old_password'] ?? '');

        // gestion des erreurs
        if (!$form_old_passwd) {
            $errors[] = "Veuillez saisir votre ancien mot de passe.";
            echo Renderer::render('users/error', ['errors' => $errors]);
            return;
        }
        $user = $this->userDAO->find($id);
        if (!$user) {
            $errors[] = "Utilisateur introuvable.";
            echo Renderer::render('users/error', ['errors' => $errors]);
            return;
        }
        $database_old_passwd = $user->getPasswd();

        // Vérification du mot de passe saisi
        if (!password_verify($form_old_passwd, $database_old_passwd)) {
            $errors[] = "L'ancien mot de passe est incorrect.";
            echo Renderer::render('users/error', ['errors' => $errors]);
            return;
        }

        // vérifier si le nouveau mot de passe correspond au critères de sécurités
        $new_passwd = $_POST['new_password'] ?? null;
        if (!$this->verifyPassword($new_passwd)) {
            $errors[] = "Le mot de passe n'est pas assez robuste";
            echo Renderer::render('users/error', ['errors' => $errors]);
            return;
        }

        // haché le nouveau mot de passe
        $hashed = password_hash($new_passwd, PASSWORD_DEFAULT);

        // update le password
        if ($this->userDAO->updatePassword($id, $hashed)) {
            // stocke le message flash en session
            $_SESSION['success_message'] = "Le mot de passe a bien été mis à jour ✅";

            // redirige vers la page show des users
            header("Location: /users/show");
            exit;
        } else {
            $errors = ['Erreur lors de la mise à jour du mot de passe'];
            echo Renderer::render('users/error', ['errors' => $errors]);
            return;
        }
    }

    /** vérifie la validité des données avec les validators
     * @param $data
     * @param bool $is_create
     * @return array
     */
    private function verifyData($data, bool $is_create = false): array {
        $errors = [];

        // Configuration du filtre
        $filtre = new Filtre();
        $filtre->addValidator('nom', new NameValidator());
        $filtre->addValidator('prenom', new NameValidator());
        $filtre->addValidator('login', new MailValidator());

        // Valider le password uniquement en création
        if ($is_create) {
            $filtre->addValidator('passwd', new PasswordValidator());
        }

        $filtre->addValidator('role', new RoleValidator());

        // Exécution de la validation
        $result = $filtre->execute($data);

        // Collecte des erreurs
        foreach ($result as $field => $isValid) {
            if (!$isValid) {
                $errors[] = $this->getErrorMessage($field);
            }
        }

        // Retour en cas d'erreurs
        if (!empty($errors)) {
            return ['valid' => false, 'errors' => $errors, 'data' => null];
        }

        // Construire les données validées
        $validData = [
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'login' => $data['login'],
            'role' => $data['role']
        ];

        // Inclure le password uniquement en création
        if ($is_create) {
            $validData['passwd'] = $data['passwd'];
        }

        return [
            'valid' => true,
            'errors' => [],
            'data' => $validData
        ];
    }

    /** this function verify if the password is valid (just the password)
     * @param string $password
     * @return bool
     */
    private function verifyPassword(string $password): bool
    {
        $filtre = new Filtre();
        $filtre->addValidator('passwd', new PasswordValidator());

        $result = $filtre->execute(['passwd' => $password]);

        if (!$result['passwd']) {
            return false;
        }
        return true;
    }

    /** return an error message according to the key $field
     * @param string $field
     * @return string
     */
    private function getErrorMessage(string $field): string
    {
        $messages = [
            'nom' => 'Le nom est invalide',
            'prenom' => 'Le prénom est invalide',
            'login' => 'Le login est invalide',
            'passwd' => 'Le mot de passe est invalide',
            'role' => 'Le rôle est invalide'
        ];
        return $messages[$field] ?? "Le champ '$field' est invalide";
    }

}
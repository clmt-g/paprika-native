<?php

namespace Paprika\controller;

use Paprika\model\DAOCaserne;
use Paprika\utils\Auth;
use Paprika\utils\CSRFToken;
use Paprika\utils\CSRFTokenSession;
use Paprika\utils\SingletonDataBaseMariaDB;
use Paprika\utils\Renderer;

class CaserneController extends BaseController
{
    private DAOCaserne $daoCaserne;
    private static CSRFToken $csrftoken;

    public function __construct()
    {
        parent::__construct();
        $this->daoCaserne = new DAOCaserne(SingletonDataBaseMariaDB::getInstance()->getLoggedPDO());
        self::$csrftoken = new CSRFTokenSession();
    }

    /** Liste des casernes */
    public function show(): void
    {
        $casernes = $this->daoCaserne->findAll();
        echo Renderer::render('caserne/caserne-list', ['casernes' => $casernes]);
    }

    /** Détail d'une caserne */
    public function detail($id): void
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) { echo "ID invalide."; return; }

        $caserne = $this->daoCaserne->find($id);
        if (!$caserne) { echo "Caserne introuvable."; return; }

        echo Renderer::render('caserne/caserne-detail', ['caserne' => $caserne]);
    }

    /** Formulaire création */
    public function create(): void
    {
        $token = CSRFTokenSession::generateToken();
        echo Renderer::render('caserne/caserne-form_create', ['csrf_token' => $token]);
    }

    /** Création POST */
    public function do_create($data): void
    {
        // Check CSRF
        $token = $data['token'] ?? null;
        if (!self::$csrftoken::check($token)) {
            echo Renderer::render('caserne/caserne-error', [
                'errors' => ["Token CSRF invalide ou expiré. Veuillez réessayer."],
                'type' => 'create',
                'id' => null
            ]);
            return;
        }

        // Validate
        $errors = $this->validateCaserneData($data);
        if (!empty($errors)) {
            echo Renderer::render('caserne/caserne-error', [
                'errors' => $errors,
                'type' => 'create',
                'id' => null
            ]);
            return;
        }

        // Sanitize et création
        $caserne = new \Paprika\model\Caserne();
        $caserne->setNumCaserne($this->daoCaserne->generateNextId())
            ->setAdresse($data['adresse'])
            ->setCp((int)$data['cp'])
            ->setVille($data['ville'])
            ->setCodeTypeC((int)$data['codeTypeC']);

        try {
            $this->daoCaserne->save($caserne);
            header("Location: /caserne/show");
            exit;
        } catch (\PDOException $e) {
            echo Renderer::render('caserne/caserne-error', [
                'errors' => ["Erreur base de données : " . $e->getMessage()],
                'type' => 'create',
                'id' => null
            ]);
        }
    }

    /** Formulaire update */
    public function update($id): void
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) { echo "ID invalide."; return; }

        $caserne = $this->daoCaserne->find($id);
        if (!$caserne) { echo "Caserne introuvable."; return; }

        $token = CSRFTokenSession::generateToken();
        echo Renderer::render('caserne/caserne-form_update', [
            'caserne' => $caserne,
            'csrf_token' => $token
        ]);
    }

    /** Update POST */
    public function do_update($data): void
    {
        // Check CSRF
        $token = $data['token'] ?? null;
        if (!self::$csrftoken::check($token)) {
            echo Renderer::render('caserne/caserne-error', [
                'errors' => ["Token CSRF invalide ou expiré. Veuillez réessayer."],
                'type' => 'update',
                'id' => $data['NumCaserne'] ?? null
            ]);
            return;
        }

        if (empty($data['NumCaserne']) || !is_numeric($data['NumCaserne'])) {
            echo "ID de la caserne invalide."; return;
        }

        $caserne = $this->daoCaserne->find((int)$data['NumCaserne']);
        if (!$caserne) { echo "Caserne introuvable."; return; }

        $errors = $this->validateCaserneData($data);
        if (!empty($errors)) {
            echo Renderer::render('caserne/caserne-error', [
                'errors' => $errors,
                'type' => 'update',
                'id' => $data['NumCaserne']
            ]);
            return;
        }

        $caserne->setAdresse($data['adresse'])
            ->setCp((int)$data['cp'])
            ->setVille($data['ville'])
            ->setCodeTypeC((int)$data['codeTypeC']);

        if ($this->daoCaserne->update($caserne)) {
            header("Location: /caserne/show"); exit;
        } else {
            echo "Erreur lors de la mise à jour de la caserne.";
        }
    }

    /** Confirmation suppression */
    public function delete($id): void
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) { echo "ID invalide."; return; }

        $caserne = $this->daoCaserne->find($id);
        if (!$caserne) { echo "Caserne introuvable."; return; }

        echo Renderer::render('caserne/caserne-confirm_delete', ['caserne' => $caserne]);
    }

    /** Suppression POST */
    public function do_delete($id): void
    {
        // Récupérer les données POST
        $data = $_POST;

        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) { echo "ID invalide."; return; }

        $caserne = $this->daoCaserne->find($id);
        if (!$caserne) { echo "Caserne introuvable."; return; }

        if ($this->daoCaserne->delete($id)) {
            header("Location: /caserne/show"); exit;
        } else {
            echo "Erreur lors de la suppression de la caserne.";
        }
    }

    /** Validation des champs d'une caserne */
    private function validateCaserneData($data): array
    {
        $errors = [];

        if (empty($data['adresse'])) $errors[] = "Adresse obligatoire.";
        if (empty($data['cp'])) $errors[] = "Code postal obligatoire.";
        if (empty($data['ville'])) $errors[] = "Ville obligatoire.";
        if (empty($data['codeTypeC'])) $errors[] = "Type de caserne obligatoire.";

        if (!empty($data['cp']) && !filter_var($data['cp'], FILTER_VALIDATE_INT))
            $errors[] = "Code postal invalide.";

        if (!empty($data['codeTypeC']) && !filter_var($data['codeTypeC'], FILTER_VALIDATE_INT))
            $errors[] = "Type de caserne invalide.";

        if (!empty($data['ville']) && !preg_match("/^[\p{L} '-]+$/u", $data['ville'])) {
            $errors[] = "Ville invalide, uniquement lettres et espaces autorisés.";
        }

        return $errors;
    }
}
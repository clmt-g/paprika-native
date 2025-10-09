<?php

namespace Paprika\controller;

use Paprika\model\DAOCaserne;
use Paprika\utils\SingletonDataBaseMariaDB;
use Paprika\utils\Renderer;

class CaserneController extends BaseController
{
    private DAOCaserne $daoCaserne;

    public function __construct()
    {
        parent::__construct();
        $this->daoCaserne = new DAOCaserne(SingletonDataBaseMariaDB::getInstance()->getLoggedPDO());
    }

    /**
     * Affiche la liste des casernes
     */
    public function show(): void
    {
        $casernes = $this->daoCaserne->findAll();
        echo Renderer::render('caserne/caserne-list', ['casernes' => $casernes]);
    }

    /**
     * Affiche le détail d'une caserne par ID
     */
    public function detail($id): void
    {
        $caserne = $this->daoCaserne->find((int)$id);
        if (!$caserne) {
            echo "Caserne introuvable";
            return;
        }
        echo \Paprika\utils\Renderer::render('caserne/caserne-detail', ['caserne' => $caserne]);
    }

    /**
     * Formulaire de création d'une caserne
     */
    public function create(): void
    {
        echo Renderer::render('caserne/caserne-form_create');
    }

    /**
     * Exécution de la création (POST)
     */
    public function do_create($data): void
    {
        $caserne = new \Paprika\model\Caserne();
        $caserne->setNumCaserne($this->daoCaserne->generateNextId())
            ->setAdresse($data['adresse'])
            ->setCp($data['cp'])
            ->setVille($data['ville'])
            ->setCodeTypeC((int)$data['codeTypeC']);

        if ($this->daoCaserne->save($caserne)) {
            header("Location: /caserne/show");
            exit;
        } else {
            echo "Erreur lors de la création de la caserne.";
        }
    }

    /**
     * Formulaire de modification d'une caserne
     */
    public function update($id): void
    {
        $caserne = $this->daoCaserne->find((int)$id);
        if (!$caserne) {
            echo "Caserne introuvable";
            return;
        }
        echo Renderer::render('caserne/caserne-form_update', ['caserne' => $caserne]);
    }

    /**
     * Exécution de la modification (POST)
     */
    public function do_update($data): void
    {
        $caserne = $this->daoCaserne->find((int)$data['NumCaserne']);
        if (!$caserne) {
            echo "Caserne introuvable";
            return;
        }

        $caserne->setAdresse($data['adresse'])
            ->setCp($data['cp'])
            ->setVille($data['ville'])
            ->setCodeTypeC((int)$data['codeTypeC']);

        if ($this->daoCaserne->update($caserne)) {
            header("Location: /caserne/show");
            exit;
        } else {
            echo "Erreur lors de la mise à jour de la caserne.";
        }
    }

    /**
     * Confirmation de suppression
     */
    public function delete($id): void
    {
        $caserne = $this->daoCaserne->find((int)$id);
        if (!$caserne) {
            echo "Caserne introuvable";
            return;
        }
        echo Renderer::render('caserne/caserne-confirm_delete', ['caserne' => $caserne]);
    }

    /**
     * suppression (POST)
     */
    public function do_delete($id): void
    {
        if ($this->daoCaserne->delete((int)$id)) {
            header("Location: /caserne/show");
            exit;
        } else {
            echo "Erreur lors de la suppression de la caserne.";
        }
    }
}
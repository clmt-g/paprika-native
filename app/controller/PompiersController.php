<?php

namespace Paprika\controller;

use Paprika\model\DAOPompiers;
use Paprika\utils\SingletonDataBaseMariaDB;
use Paprika\utils\Renderer;
use DateTime;

/**
 *
 */

class PompiersController extends BaseController
{
    private DAOPompiers $pompierDAO;

    public function __construct()
    {
        parent::__construct();
        $this->pompierDAO = new DAOPompiers(SingletonDataBaseMariaDB::getInstance()->getLoggedPDO());
    }

    /**
     * @return string
     */
    public function create(): void
    {
        echo Renderer::render('pompiers/create');
    }

    public function do_create($data): void
    {
        // TODO: Implement do_create() method.
    }

    public function show(): void
    {
        $pompiers = $this->pompierDAO->findAll(100000);
        if (!$pompiers) {
            header("location: /404.php");
            exit;
        }
        $i = 1;
        echo Renderer::render('pompiers/show', ['pompiers' => $pompiers, 'i' => $i]);
    }

    public function detail($id): void
    {
        if (!$id) {
            header('Location: /pompiers/show');
            exit;
        }
        $pompier = $this->pompierDAO->find($id);

        if (!$pompier) {
            header("location: /404.php");
            exit;
        }
        echo Renderer::render('pompiers/detail', ['pompier' => $pompier]);
    }

    public function update($id): void
    {
        if (!$id) {
            header('Location: /pompiers/show');
            exit;
        }
        $pompier = $this->pompierDAO->find($id);

        if (!$pompier) {
            header("location: /404.php");
            exit;
        }
        echo Renderer::render('pompiers/update', ['pompier' => $pompier]);
    }

    public function do_update($data): void
    {
        // variables pour gestion d'erreur
        $flag = false;
        $errors = [];

        // recupérer le pompier
        $pompier = $this->pompierDAO->find($data);
        if (!$pompier) {
            $flag = true;
            $errors[] = "Le pompier n'existe pas !";
        }

        $matricule = $_POST['matricule'];
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $chefAgret = $_POST['chefAgret'];
        $numCaserne = (int) $_POST['numCaserne'];
        $dateNaissance = $_POST['dateNaissance'];
        $codeGrade = $_POST['codeGrade'];
        $matriculeRespo = $_POST['matriculeRespo'];

        // vérifier que les champs ne sont pas vides
        if (
            empty($matricule) || empty($prenom) || empty($nom) || empty($chefAgret) || empty($numCaserne)
            || empty($dateNaissance) || empty($codeGrade) || empty($matriculeRespo)
        ) {
            $flag = true;
            $errors[] = 'Les données ne peuvent être vides';
        }
        // vérifier que le format de la date est bon
        if (!DateTime::createFromFormat('Y-m-d', $_POST['dateNaissance'])) {
            $flag = true;
            $errors[] = "Le format de la date n'est pas valide (format valide : YYYY-MM-DD)";
        }

        // vérifier que le type de données est bien un nombre pour caserne
        if (!is_int($numCaserne)) {
            $flag = true;
            $errors[] = "Le type de données de la caserne doit être un nombre";
        }

        // nétoyer les données
        $matricule = htmlspecialchars($matricule, ENT_QUOTES, 'UTF-8');
        $prenom = htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8');
        $nom = htmlspecialchars($nom, ENT_QUOTES, 'UTF-8');
        $chefAgret = htmlspecialchars($chefAgret, ENT_QUOTES, 'UTF-8');
        $dateNaissance = htmlspecialchars($dateNaissance, ENT_QUOTES, 'UTF-8');
        $codeGrade = htmlspecialchars($codeGrade, ENT_QUOTES, 'UTF-8');
        $matriculeRespo = htmlspecialchars($matriculeRespo, ENT_QUOTES, 'UTF-8');

        // vérification régles métier
        // age valide
        $age = (new DateTime())->diff(new DateTime($_POST['dateNaissance']))->y;
        if ($age < 16) {
            $flag = true;
            $errors[] = "Le pompier doit avoir au moins 16 ans";
        }
        // FIXME : la caserne existe
        // le responsable existe
        if (!($this->pompierDAO->find($matriculeRespo))) {
            $flag = true;
            $errors[] = "Le matricule du responsable n'existe pas";
        }

        // update du pompier si pas d'erreur
        if ($flag == false) {
            $pompier->setNom($nom);
            $pompier->setPrenom($prenom);
            $pompier->setChefAgret($chefAgret);
            $pompier->setNumCaserne($numCaserne);
            $pompier->setDateNaissance($dateNaissance);
            $pompier->setCodeGrade($codeGrade);
            $pompier->setMatriculeRespo($matriculeRespo);
            $this->pompierDAO->update($pompier);

            header('Location: /pompiers/show/detail/' . $matricule);
            exit;
        } else {
            echo Renderer::render('pompiers/error', ['errors' => $errors, 'matricule' => $matricule]);
        }
    }

    public function delete($id): void
    {
        $pompier = $this->pompierDAO->find($id);
        if (!$pompier) {
            echo "Pompier introuvable";
            return;
        }
        echo Renderer::render('pompiers/delete', ['pompier' => $pompier]);
    }

    public function do_delete($id): void
    {
        $pompier = $this->pompierDAO->find($id);
        if ($this->pompierDAO->delete($pompier)) {
            header("Location: /pompiers/show");
            exit;
        } else {
            echo "Erreur lors de la suppression du pompier.";
        }
    }
}

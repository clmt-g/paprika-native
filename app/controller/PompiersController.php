<?php

namespace Paprika\controller;

use Paprika\model\DAOPompiers;
use Paprika\model\Pompiers;
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
        $result = $this->verifyData(isCreate: true);

        if (!$result['valid']) {
            echo Renderer::render('pompiers/error',
                ['errors' => $result['errors'], 'type' => 'create']
            );
            return;
        }
        $cleanData = $result['data'];
        $pompier = new Pompiers($cleanData['prenom'], $cleanData['nom'], $cleanData['chefAgret'],
            $cleanData['dateNaissance'] , $cleanData['numCaserne'], $cleanData['codeGrade'], $cleanData['matriculeRespo']);
        $this->pompierDAO->save($pompier);
        $matricule = $pompier->getMatricule();

        header('Location: /pompiers/show/detail/' . $matricule);
        exit;
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
        $result = $this->verifyData(isCreate: false);

        if (!$result['valid']) {
            echo Renderer::render('pompiers/error',
                ['errors' => $result['errors'], 'type' => 'update', 'matricule' => $data]
            );
            return;
        }

        $pompier = $this->pompierDAO->find($data);
        if (!$pompier) {
            echo Renderer::render('pompiers/error',
                ['errors' => ["Le pompier n'existe pas !"], 'type' => 'update', 'matricule' => $data]
            );
            return;
        }

        // Récupérer les données nettoyées
        $cleanData = $result['data'];

        $pompier->setPrenom($cleanData['prenom']);
        $pompier->setNom($cleanData['nom']);
        $pompier->setChefAgret($cleanData['chefAgret']);
        $pompier->setDateNaissance($cleanData['dateNaissance']);
        $pompier->setNumCaserne($cleanData['numCaserne']);
        $pompier->setCodeGrade($cleanData['codeGrade']);
        $pompier->setMatriculeRespo($cleanData['matriculeRespo']);

        $this->pompierDAO->update($pompier);
        header('Location: /pompiers/show/detail/' . $cleanData['matricule']);
        exit;
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

    private function verifyData($isCreate = false): array
    {
        $errors = [];

        // Récupérer les données du formulaire
        $matricule = $_POST['matricule'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $nom = $_POST['nom'] ?? '';
        $chefAgret = $_POST['chefAgret'] ?? '';
        $numCaserne = (int) ($_POST['numCaserne'] ?? 0);
        $dateNaissance = $_POST['dateNaissance'] ?? '';
        $codeGrade = $_POST['codeGrade'] ?? '';
        $matriculeRespo = $_POST['matriculeRespo'] ?? '';

        // Vérifier que les champs ne sont pas vides
        // Pour create : matricule peut être vide (il sera généré)
        // Pour update : matricule est obligatoire
        if (!$isCreate && empty($matricule)) {
            $errors[] = 'Le matricule est requis';
        }

        if (empty($prenom)) {
            $errors[] = 'Le prénom est requis';
        }

        if (empty($nom)) {
            $errors[] = 'Le nom est requis';
        }

        if (empty($chefAgret)) {
            $errors[] = 'Le statut chef d\'agrès est requis';
        }

        if (empty($numCaserne)) {
            $errors[] = 'Le numéro de caserne est requis';
        }

        if (empty($dateNaissance)) {
            $errors[] = 'La date de naissance est requise';
        }

        if (empty($codeGrade)) {
            $errors[] = 'Le code grade est requis';
        }

        if (empty($matriculeRespo)) {
            $errors[] = 'Le matricule du responsable est requis';
        }

        // Si des champs sont vides, retourner les erreurs
        if (!empty($errors)) {
            return ['valid' => false, 'errors' => $errors, 'data' => null];
        }

        // Vérifier que le format de la date est bon
        if (!DateTime::createFromFormat('Y-m-d', $dateNaissance)) {
            $errors[] = "Le format de la date n'est pas valide (format valide : YYYY-MM-DD)";
        }

        // Vérifier que le type de données est bien un nombre pour caserne
        if (!is_int($numCaserne) || $numCaserne <= 0) {
            $errors[] = "Le numéro de caserne doit être un nombre valide";
        }

        // Vérifier que chefAgret est valide (O ou N)
        if (!in_array($chefAgret, ['O', 'N'])) {
            $errors[] = "Le statut chef d'agrès doit être 'O' ou 'N'";
        }

        if (!empty($errors)) {
            return ['valid' => false, 'errors' => $errors, 'data' => null];
        }

        // Nettoyer les données
        $matricule = htmlspecialchars($matricule, ENT_QUOTES, 'UTF-8');
        $prenom = htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8');
        $nom = htmlspecialchars($nom, ENT_QUOTES, 'UTF-8');
        $chefAgret = htmlspecialchars($chefAgret, ENT_QUOTES, 'UTF-8');
        $dateNaissance = htmlspecialchars($dateNaissance, ENT_QUOTES, 'UTF-8');
        $codeGrade = htmlspecialchars($codeGrade, ENT_QUOTES, 'UTF-8');
        $matriculeRespo = htmlspecialchars($matriculeRespo, ENT_QUOTES, 'UTF-8');

        // Vérification règles métier
        // Age valide (au moins 16 ans)
        $age = (new DateTime())->diff(new DateTime($dateNaissance))->y;
        if ($age < 16) {
            $errors[] = "Le pompier doit avoir au moins 16 ans";
        }

        // Le responsable existe
        if (!$this->pompierDAO->find($matriculeRespo)) {
            $errors[] = "Le matricule du responsable n'existe pas";
        }

        // FIXME : vérifier que la caserne existe

        if (!empty($errors)) {
            return ['valid' => false, 'errors' => $errors, 'data' => null];
        }

        // Retourner les données nettoyées si tout est valide
        return [
            'valid' => true,
            'errors' => [],
            'data' => [
                'matricule' => $matricule,
                'prenom' => $prenom,
                'nom' => $nom,
                'chefAgret' => $chefAgret,
                'numCaserne' => $numCaserne,
                'dateNaissance' => $dateNaissance,
                'codeGrade' => $codeGrade,
                'matriculeRespo' => $matriculeRespo
            ]
        ];
    }
}

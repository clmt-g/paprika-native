<?php

namespace Paprika\controller;

use DateMalformedStringException;
use Paprika\model\DAOCaserne;
use Paprika\model\DAOPompiers;
use Paprika\model\Pompiers;
use Paprika\utils\Filtre;
use Paprika\utils\SingletonDataBaseMariaDB;
use Paprika\utils\Renderer;
use Paprika\model\DAOGrade;
use Paprika\model\Grade;
use DateTime;
use Paprika\utils\validators\DateNaissanceValidator;
use Paprika\utils\validators\GradeValidator;
use Paprika\utils\validators\MatriculeValidator;
use Paprika\utils\validators\NameValidator;

/** controller class : used to display the pages in view through the renderer */
class PompiersController extends BaseController
{
    private DAOPompiers $pompierDAO;
    private DAOCaserne $caserneDAO;
    private DAOGrade $gradeDAO;

    public function __construct()
    {
        parent::__construct();
        $this->pompierDAO = new DAOPompiers(SingletonDataBaseMariaDB::getInstance()->getLoggedPDO());
        $this->caserneDAO = new DAOCaserne(SingletonDataBaseMariaDB::getInstance()->getLoggedPDO());
        $this->gradeDAO = new DAOGrade(SingletonDataBaseMariaDB::getInstance()->getLoggedPDO());
    }

    /** display the create page
     * @return void
     */
    public function create(): void
    {
        // recupere les casernesNum et ville pour les afficher dans une balise option
        $casernes = $this->caserneDAO->getAllVilles();
        if (!$casernes) {
            echo 'Erreur: aucune caserne disponible';
            exit;
        }

        // récuperer les grades pour les afficher dans une balise option
        $codesGrade = $this->gradeDAO->getAllCodeGrade();
        if (!$codesGrade) {
            echo 'Erreur: aucune grade disponible';
            exit;
        }
        echo Renderer::render('pompiers/create', ['casernes' => $casernes, 'codesGrade' => $codesGrade]);
    }

    /** create a pompier
     * @param $data
     * @return void
     * @throws \DateMalformedStringException
     */
    public function do_create($data): void
    {
        // vérifie la validité des données submit
        $data = [
            'matricule' => $_POST['matricule'] ?? '',
            'prenom' => $_POST['prenom'] ?? '',
            'nom' => $_POST['nom'] ?? '',
            'chefAgret' => $_POST['chefAgret'] ?? '',
            'numCaserne' => $_POST['numCaserne'] ?? 0,
            'dateNaissance' => $_POST['dateNaissance'] ?? '',
            'codeGrade' => $_POST['codeGrade'] ?? '',
            'matriculeRespo' => $_POST['matriculeRespo'] ?? '',
        ];

        $result = $this->verifyData($data, true);

        if (!$result['valid']) {
            echo Renderer::render('pompiers/error',
                ['errors' => $result['errors'], 'type' => 'create']
            );
            return;
        }
        $cleanData = $result['data'];

        // créer une instance de pompier et appel de la méthode save
        $pompier = new Pompiers($cleanData['prenom'], $cleanData['nom'], $cleanData['chefAgret'],
            $cleanData['dateNaissance'] , $cleanData['numCaserne'], $cleanData['codeGrade'], $cleanData['matriculeRespo']);
        $this->pompierDAO->save($pompier);
        $matricule = $pompier->getMatricule();

        header('Location: /pompiers/show/detail/' . $matricule);
        exit;
    }

    /** display the show page
     * @return void
     */
    public function show(): void
    {
        // gestion des erreurs
        $pompiers = $this->pompierDAO->findAll(100000);
        if (!$pompiers) {
            header("location: /404.php");
            exit;
        }

        // affichage des villes plutot que des numéro de caserne
        $villes = [];
        foreach ($pompiers as $pompier) {
            $villes[$pompier->getMatricule()] = $this->caserneDAO->findCaserneVille($pompier->getNumCaserne());
        }

        // affichage des nom de grade plutot que des numéro
        $nomsGrades = [];
        foreach ($pompiers as $pompier) {
            $nomsGrades[$pompier->getMatricule()] = $this->gradeDAO->getCodeGradeNom($pompier->getCodeGrade());
        }

        // variable pour nuémroter les lignes du tableau
        $i = 1;

        echo Renderer::render('pompiers/show', ['pompiers' => $pompiers, 'villes' => $villes, 'i' => $i, 'nomsGrades' => $nomsGrades,]);
    }

    /** display the detail page
     * @param $id
     * @return void
     */
    public function detail($id): void
    {
        // gestion des erreurs
        if (!$id) {
            header('Location: /pompiers/show');
            exit;
        }

        // affichage du pompier par l'id et gestion des erreurs
        $pompier = $this->pompierDAO->find($id);
        if (!$pompier) {
            header("location: /404.php");
            exit;
        }

        // affichage des nom de caserne et grade dans des balises option
        $caserne = $this->caserneDAO->findCaserneVille($pompier->getNumCaserne());
        if (!$caserne) {
            $caserne = 'error';
        }
        $grade = $this->gradeDAO->getCodeGradeNom($pompier->getCodeGrade());
        if (!$grade) {
            $grade = 'error';
        }
        echo Renderer::render('pompiers/detail', ['pompier' => $pompier, 'caserne' => $caserne, 'grade' => $grade]);
    }

    /** display the update page
     * @param $id
     * @return void
     */
    public function update($id): void
    {
        // gestion des erreurs
        if (!$id) {
            header('Location: /pompiers/show');
            exit;
        }

        // affichage en fonction du pompier + gestion des erreurs
        $pompier = $this->pompierDAO->find($id);
        if (!$pompier) {
            header("location: /404.php");
            exit;
        }

        // Récupérer les noms des casernes disponibles
        $casernes = $this->caserneDAO->getAllVilles();
        if (!$casernes) {
            echo 'Erreur: aucune caserne disponible';
            exit;
        }

        // récuperer les noms des grades
        $codesGrade = $this->gradeDAO->getAllCodeGrade();
        if (!$codesGrade) {
            echo 'Erreur: aucune grade disponible';
            exit;
        }

        echo Renderer::render('pompiers/update', [
            'pompier' => $pompier,
            'casernes' => $casernes,
            'codesGrade' => $codesGrade
        ]);
    }

    /** update a pompier
     * @param $data
     * @return void
     * @throws \DateMalformedStringException
     */
    public function do_update($data): void
    {
        // vérifie la validité des données submit
        $valide_data = [
            'matricule' => $_POST['matricule'] ?? '',
            'prenom' => $_POST['prenom'] ?? '',
            'nom' => $_POST['nom'] ?? '',
            'chefAgret' => $_POST['chefAgret'] ?? '',
            'numCaserne' => $_POST['numCaserne'] ?? 0,
            'dateNaissance' => $_POST['dateNaissance'] ?? '',
            'codeGrade' => $_POST['codeGrade'] ?? '',
            'matriculeRespo' => $_POST['matriculeRespo'] ?? '',
        ];

        $result = $this->verifyData($valide_data, false);

        if (!$result['valid']) {
            echo Renderer::render('pompiers/error',
                ['errors' => $result['errors'], 'type' => 'update', 'matricule' => $data]
            );
            return;
        }

        // find le pompier
        $pompier = $this->pompierDAO->find($data);
        if (!$pompier) {
            echo Renderer::render('pompiers/error',
                ['errors' => ["Le pompier n'existe pas !"], 'type' => 'update', 'matricule' => $data]
            );
            return;
        }

        // Récupérer les données nettoyées
        $cleanData = $result['data'];

        // update les informations
        $pompier->setPrenom($cleanData['prenom']);
        $pompier->setNom($cleanData['nom']);
        $pompier->setChefAgret($cleanData['chefAgret']);
        $pompier->setDateNaissance($cleanData['dateNaissance']);
        $pompier->setNumCaserne($cleanData['numCaserne']);
        $pompier->setCodeGrade($cleanData['codeGrade']);
        $pompier->setMatriculeRespo($cleanData['matriculeRespo']);

        // appel a la méthode update + redirection
        $this->pompierDAO->update($pompier);
        header('Location: /pompiers/show/detail/' . $cleanData['matricule']);
        exit;
    }

    /** display the delete page
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        // affichage du pompier en fonction de l'id + gestion des erreurs
        $pompier = $this->pompierDAO->find($id);
        if (!$pompier) {
            echo "Pompier introuvable";
            return;
        }
        // affichage du modal de suppresion
        echo Renderer::render('pompiers/delete', ['pompier' => $pompier]);
    }

    /** delete a pompier
     * @param $id
     * @return void
     */
    public function do_delete($id): void
    {
        // appel de la méthode delete pour le pompier + gestion d'erreur
        $pompier = $this->pompierDAO->find($id);
        if ($this->pompierDAO->delete($pompier)) {
            header("Location: /pompiers/show");
            exit;
        } else {
            echo "Erreur lors de la suppression du pompier.";
        }
    }

    /**
     * Verify the data submitted when either updating or creating a pompier
     * @param array $data Les données à valider
     * @param bool $isCreate
     * @return array
     */
    private function verifyData(array $data, bool $isCreate = false): array
    {
        $errors = [];

        // --- Configuration du filtre ---
        $filtre = new Filtre();

        // Matricule : optionnel en création, obligatoire en update
        if (!$isCreate) {
            $filtre->addValidator('matricule', new MatriculeValidator());
        }

        $filtre->addValidator('prenom', new NameValidator());
        $filtre->addValidator('nom', new NameValidator());
        $filtre->addValidator('dateNaissance', new DateNaissanceValidator());
        $filtre->addValidator('codeGrade', new GradeValidator());
        $filtre->addValidator('matriculeRespo', new MatriculeValidator());

        // --- Exécution de la validation ---
        $result = $filtre->execute($data);

        // --- Collecte des erreurs depuis le filtre ---
        foreach ($result as $field => $isValid) {
            if (!$isValid) {
                $errors[] = $this->getErrorMessage($field);
            }
        }

        // --- Validations métier supplémentaires ---
        $numCaserne = (int) ($data['numCaserne'] ?? 0);
        $chefAgret = $data['chefAgret'] ?? '';

        if ($numCaserne <= 0) {
            $errors[] = "Le numéro de caserne doit être un nombre valide";
        } elseif (!$this->caserneDAO->find($numCaserne)) {
            $errors[] = "La caserne avec le numéro $numCaserne n'existe pas";
        }

        if (!in_array($chefAgret, ['O', 'N'], true)) {
            $errors[] = "Le statut chef d'agrès doit être 'O' ou 'N'";
        }

        // --- Retour ---
        if (!empty($errors)) {
            return ['valid' => false, 'errors' => $errors, 'data' => null];
        }

        return [
            'valid' => true,
            'errors' => [],
            'data' => [
                'matricule' => $data['matricule'] ?? '',
                'prenom' => $data['prenom'] ?? '',
                'nom' => $data['nom'] ?? '',
                'chefAgret' => $chefAgret,
                'numCaserne' => $numCaserne,
                'dateNaissance' => $data['dateNaissance'] ?? '',
                'codeGrade' => $data['codeGrade'] ?? '',
                'matriculeRespo' => $data['matriculeRespo'] ?? ''
            ]
        ];
    }

    /**
     * Retourne un message d'erreur personnalisé pour chaque champ
     */
    private function getErrorMessage(string $field): string
    {
        $messages = [
            'matricule' => 'Le matricule est invalide',
            'prenom' => 'Le prénom est invalide',
            'nom' => 'Le nom est invalide',
            'dateNaissance' => 'La date de naissance est invalide',
            'codeGrade' => 'Le code grade est invalide',
            'matriculeRespo' => 'Le matricule du responsable est invalide'
        ];

        return $messages[$field] ?? "Le champ '$field' est invalide";
    }
}

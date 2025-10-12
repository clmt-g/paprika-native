<?php

namespace Paprika\controller;

use Paprika\model\DAOCaserne;
use Paprika\model\DAOPompiers;
use Paprika\model\Pompiers;
use Paprika\utils\SingletonDataBaseMariaDB;
use Paprika\utils\Renderer;
use DateTime;

/** controller class : used to display the pages in view through the renderer */
class PompiersController extends BaseController
{
    private DAOPompiers $pompierDAO;
    private DAOCaserne $caserneDAO;

    public function __construct()
    {
        parent::__construct();
        $this->pompierDAO = new DAOPompiers(SingletonDataBaseMariaDB::getInstance()->getLoggedPDO());
        $this->caserneDAO = new DAOCaserne(SingletonDataBaseMariaDB::getInstance()->getLoggedPDO());
    }

    /** display the create page
     * @return string
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
        $codesGrade = $this->pompierDAO->getAllCodeGrade();
        if (!$codesGrade) {
            echo 'Erreur: aucune grade disponible';
            exit;
        }
        echo Renderer::render('pompiers/create', ['casernes' => $casernes, 'codesGrade' => $codesGrade]);
    }

    /** create a pompier
     * @param $data
     * @return void
     */
    public function do_create($data): void
    {
        // vérifie la validité des données submit
        $result = $this->verifyData(isCreate: true);

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
            $nomsGrades[$pompier->getMatricule()] = $this->pompierDAO->getCodeGradeNom($pompier->getCodeGrade());
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
        $grade = $this->pompierDAO->getCodeGradeNom($pompier->getCodeGrade());
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
        $codesGrade = $this->pompierDAO->getAllCodeGrade();
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
     */
    public function do_update($data): void
    {
        // vérifier la validité des données
        $result = $this->verifyData(isCreate: false);

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

    /** verify the data submited when either updatin or creating a pompier
     * @param $isCreate
     * @return array
     * @throws \DateMalformedStringException
     */
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

        // la caserne existe
        if (!$this->caserneDAO->find($numCaserne)) {
            $errors[] = "La caserne n'existe pas";
        }

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

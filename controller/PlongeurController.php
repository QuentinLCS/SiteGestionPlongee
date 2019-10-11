<?php

require_once('_ControllerClass.php');

class PlongeurController extends _ControllerClass
{
    private $plongeurManager;

    private $aptitudeManager;

    private $personneManager;

    public function __construct($url)
    {
        $this->plongeurManager = new PlongeurManager();
        $this->aptitudeManager = new AptitudeManager();
        $this->personneManager = new PersonneManager();

        $urlSize = parent::__construct($url);

        if ($urlSize > 1)
            if ($url[1] == 'add')
                $this->add();
            else if($url[1] == 'edit')
                $this->edit();
            else
                throw new Exception('Page introuvable');
    }

    /**
     * Fonction chargée au chargement de la page.
     * @throws Exception
     */
    public function index()
    {
        (new View('plongeur/plongeur_index'))->generate([
            'allPlongeurs' => $this->plongeurManager->getAll()
        ]);
    }

    public function edit()
    {
        if (!isset($_GET['per_num']) || !isset($_GET['apt_code']))
            header('location: '.URL);

        $plongeur = $this->plongeurManager->getOne([
            'PER_NUM' => $_GET['per_num'],
            'APT_CODE' => $_GET['apt_code']]);


        if ( isset($_POST['submit']) ) {
            if ( !empty($_POST['nom']) && !empty($_POST['prenom']) ) {
                $nom = strtoupper($_POST['nom']);
                $prenom = ucfirst($_POST['prenom']);
                $aptitude = $_POST['aptitude'];

                $personnes = $this->personneManager->getAll();

                $nbPersonnes = count($personnes);

                $i = 0;

                // Si le prénom ou le nom a été modifié
                if ($nom != $plongeur[0]->getPersonne()[0]->getPerNom() || $prenom != $plongeur[0]->getPersonne()[0]->getPerPrenom())
                    while (($nom != $personnes[$i]->GetPerNom() || $prenom != $personnes[$i]->GetPerPrenom()) && ++$i < $nbPersonnes);
                else
                    $i = $nbPersonnes;


                if ($i == $nbPersonnes) {
                    $plongeur[0]->getPersonne()[0]->setPerNom($nom);
                    $plongeur[0]->getPersonne()[0]->setPerPrenom($prenom);
                    $plongeur[0]->setAptCode($aptitude);
                    $this->plongeurManager->update($plongeur);
                    header("Location: /plongeur");
                } else
                    echo "Personne déjà enregistrée.";
            }
        }

        (new View('plongeur/plongeur_editform'))->generate([
            'plongeur' => $plongeur,
            'allAptitudes' => $this->aptitudeManager->getAll()
        ]);
    }

    public function add()
    {
        (new View('plongeur/plongeur_addform'))->generate([]);
    }
}
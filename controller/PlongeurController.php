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
            if($url[1] == 'edit')
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
        $this->add();

        (new View('plongeur/plongeur_index'))->generate([
            'allPlongeurs' => $this->plongeurManager->getAll(),
            'allAptitudes' => $this->aptitudeManager->getAll()
        ]);
    }

    public function edit()
    {
        if (!isset($_GET['per_num']))
            header('location: '.URL.'/plongeur');

        $plongeur = $this->plongeurManager->getOne([
            'PER_NUM' => $_GET['per_num']]);

        if (is_null($plongeur))
            header('location: '.URL.'/plongeur');

        if ( isset($_POST['submit']) )
            $this->verification($plongeur);

        (new View('plongeur/plongeur_editform'))->generate([
            'plongeur' => $plongeur,
            'allAptitudes' => $this->aptitudeManager->getAll()
        ]);
    }

    private function add()
    {
        if ( isset($_POST['submit']) ) {
            $plongeur = new Plongeur($_POST);
            $this->verification($plongeur);

        }
    }

    private function verification($plongeur)
    {
        if ( !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['aptitude']) ) {
            $nom = strtoupper($_POST['nom']);
            $prenom = ucfirst($_POST['prenom']);
            $aptitude = $_POST['aptitude'];

            $personnes = $this->personneManager->getAll();

            $nbPersonnes = count($personnes);

            $i = 0;

            // Si le prénom ou le nom a été modifié
            if ($nom != $plongeur[0]->getPersonne()[0]->getPerNom() || $prenom != $plongeur[0]->getPersonne()[0]->getPerPrenom())
                while (($nom != $personnes[$i]->GetPerNom() || $prenom != $personnes[$i]->GetPerPrenom()) && ++$i < $nbPersonnes) ;
            else
                $i = $nbPersonnes;


            if ($i == $nbPersonnes) {
                $plongeur[0]->getPersonne()[0]->setPerNom($nom);
                $plongeur[0]->getPersonne()[0]->setPerPrenom($prenom);
                $plongeur[0]->setAptCode($aptitude);
                $this->plongeurManager->update($plongeur);
                header("Location: /plongeur");
            } else
                echo 'Personne déjà enregistrée.';
        }
    }
}
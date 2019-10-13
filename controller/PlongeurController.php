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
        if (isset($_POST['submit']))
            $this->add();

        $searchedPlongeurs = null;

        if ( isset($_POST['search']) ) {

            if (!empty($_POST['searchNom']))
                $search['nom'] = $_POST['searchNom'];

            if (!empty($_POST['searchPrenom']))
                $search['prenom'] = $_POST['searchPrenom'];

            if (!isset($_POST['searchInactive']))
                $search['inactive'] = '';

            if (!empty($_POST['searchNom']) || !empty($_POST['searchPrenom']) || !isset($_POST['searchInactive']))
                $searchedPlongeurs = $this->plongeurManager->getSearchResult($search);

        }



       // $this->delete();

        (new View('plongeur/plongeur_index'))->generate([
            'allPlongeurs' => $this->plongeurManager->getAll(),
            'allAptitudes' => $this->aptitudeManager->getAll(),
            'searchedPlongeurs' => $searchedPlongeurs
        ]);
    }

    public function edit()
    {
        if (!isset($_GET['per_num']))
            header('location: /plongeur');

        $plongeur = $this->plongeurManager->getOne([
            'PER_NUM' => $_GET['per_num']]);

        if (is_null($plongeur))
            header('location: /plongeur');

        if ( isset($_POST['submit']) )
            $this->verification($plongeur);

        (new View('plongeur/plongeur_editform'))->generate([
            'plongeur' => $plongeur,
            'allAptitudes' => $this->aptitudeManager->getAll()
        ]);
    }

    private function add()
    {
        if ( isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['aptitude']) ) {

            if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['aptitude'])) {
                $nom = strtoupper($_POST['nom']);
                $prenom = ucfirst($_POST['prenom']);

                $plongeur[] = new Plongeur([]);
                $personne[] = new Personne([
                    'PER_NOM' => $nom,
                    'PER_PRENOM' => $prenom
                ]);

                $plongeur[0]->setPersonne($personne);

                $this->verification($plongeur, true);

            } else
                echo 'Tous les champs ne sont pas remplis.';

        }
    }

    public function delete(){
        if (!isset($_GET['per_num']))
            header('location: plongeur');

        $plongeur = $this->plongeurManager->getOne([
            'PER_NUM' => $_GET['per_num']]);

        if (is_null($plongeur))
            header('location: plongeur');

        $this->plongeurManager->delete($plongeur);
    }

    private function verification($plongeur, $add = false)
    {
        if ( $add || (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['aptitude'])) ) {

                if ($add || (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['aptitude']))) {
                    $nom = strtoupper($_POST['nom']);
                    $prenom = ucfirst($_POST['prenom']);
                    $aptitude = $_POST['aptitude'];


                    $personnes = $this->personneManager->getAll();

                    $nbPersonnes = count($personnes);

                    $i = 0;

                    // Si le prénom ou le nom a été modifié
                    if ($nom != $plongeur[0]->getPersonne()[0]->getPerNom() || $prenom != $plongeur[0]->getPersonne()[0]->getPerPrenom() || $add)
                        while (($nom != $personnes[$i]->getPerNom() || $prenom != $personnes[$i]->getPerPrenom()) && (++$i < $nbPersonnes)) ;
                    else
                        $i = $nbPersonnes;

                    if ($i == $nbPersonnes) {
                        $plongeur[0]->getPersonne()[0]->setPerNom($nom);
                        $plongeur[0]->getPersonne()[0]->setPerPrenom($prenom);

                        $aptitudeObject = $this->aptitudeManager->getOne(['APT_CODE' => $aptitude]);

                        if (!is_null($aptitudeObject))
                            if ($add)
                                $plongeur[0]->setAptitude($aptitudeObject);
                            $plongeur[0]->setAptCode($aptitude);

                        $this->plongeurManager->update($plongeur, $add);

                        header('location: '.URL.'/plongeur');
                    } else
                        echo 'Personne déjà enregistrée.';
                } else
                    echo 'Tous les champs ne sont pas remplis.';

        }
    }

}
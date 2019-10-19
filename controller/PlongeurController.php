<?php

require_once('_ControllerClass.php');
require_once('/model/utils/traitement.php');

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
            if($url[1] == 'show')
                $this->show();
            if($url[1] == 'edit')
                $this->edit();
            else if($url[1] == 'delete')
                $this->delete();
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

            if (isset($_POST['searchInactive']))
                $search['inactive'] = '';

            if (!empty($_POST['searchNom']) || !empty($_POST['searchPrenom']) || isset($_POST['searchInactive']))
                $searchedPlongeurs = $this->plongeurManager->getSearchResult($search);

        }



        (new View('plongeur/plongeur_index'))->generate([
            'allPlongeurs' => $this->plongeurManager->getAllActive(),
            'allAptitudes' => $this->aptitudeManager->getAll(),
            'searchedPlongeurs' => $searchedPlongeurs
        ]);
    }

    public function show() {

        if (!isset($_GET['per_num']))
            header('location: /plongeur');

        $plongeur = $this->plongeurManager->getOne([
            'PER_NUM' => $_GET['per_num']]);

        if (is_null($plongeur))
            header('location: /plongeur');

        $this->edit($plongeur);

        (new View('plongeur/plongeur_show/plongeur_show_index'))->generate([
            'plongeur' => $plongeur,
            'allAptitudes' => $this->aptitudeManager->getAll()
        ]);
    }

    private function edit($plongeur)
    {


        if ( isset($_POST['edit']) )
            $this->verification($plongeur);

    }

    private function add()
    {
        if ( isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['aptitude']) ) {

            if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['aptitude'])) {
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                if($this->verifEntree($nom,$prenom)) {
                    $plongeur[] = new Plongeur([]);
                    $personne[] = new Personne([
                        'PER_NOM' => traitementNom($nom),
                        'PER_PRENOM' => traitementPrenom($prenom)
                    ]);

                    $plongeur[0]->setPersonne($personne);

                    $this->verification($plongeur, true);
                }
                else
                    echo "le nom ou le prénom n'est pas correct";


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
            header('location: /plongeur');

        if ( isset($_POST['submit']) ) {
            $this->plongeurManager->delete($plongeur);
            header('location: /plongeur');
        }

        (new View('plongeur/plongeur_removeform'))->generate([
            'plongeur' => $plongeur,

        ]);

    }

    public function verifEntree($nom,$prenom){
        if(prenomCorrect($prenom) && nomCorrect($nom))
            return true;
        else
            return false;
    }

    private function verification($plongeur, $add = false)
    {
        if ( $add || (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['aptitude'])) ) {

                if ($add || (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['aptitude']))) {
                    $nom = $_POST['nom'];
                    $prenom = $_POST['prenom'];
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
                        if($this->verifEntree($nom,$prenom)) {
                            $plongeur[0]->getPersonne()[0]->setPerNom($nom);
                            $plongeur[0]->getPersonne()[0]->setPerPrenom($prenom);

                            $aptitudeObject = $this->aptitudeManager->getOne(['APT_CODE' => $aptitude]);

                            if (!is_null($aptitudeObject))
                                if ($add)
                                    $plongeur[0]->setAptitude($aptitudeObject);
                            $plongeur[0]->setAptCode($aptitude);

                            $this->plongeurManager->update($plongeur, $add);
                            header('location: '.URL.'/plongeur');
                        }
                        else
                                echo "le nom ou le prénom n'est pas correct";

                    } else
                        echo 'Personne déjà enregistrée.';
                } else
                    echo 'Tous les champs ne sont pas remplis.';

        }
    }

}
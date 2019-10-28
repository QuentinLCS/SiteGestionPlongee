<?php

require_once('_ControllerClass.php');
require_once('model/utils/traitement.php');

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
            elseif ($url[1] == 'delete')
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
        if (isset($_POST['submitAJOUTER']))
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


        $tmp = 0;
        (new View('plongeur/plongeur_index'))->generate([
            'allPlongeurs' => $this->plongeurManager->getAllActive(),
            'allAptitudes' => $this->aptitudeManager->getAll(),
            'searchedPlongeurs' => $searchedPlongeurs,
            'directeur' => $tmp,
            'securite' => $tmp
        ]);
    }

    public function show() {

        if (!isset($_GET['per_num']))
            header('location: /plongeur');

        $plongeur = $this->plongeurManager->getOne([
            'PER_NUM' => $_GET['per_num']]);

        $dir  = DataBase::$db->LireDonnees('SELECT * FROM PLO_DIRECTEUR WHERE PER_NUM='.$_GET['per_num']);
        if(count($dir)>0)
            $dir = 1;
        else{
            $dir=0;
        }

        $secu  = DataBase::$db->LireDonnees('SELECT * FROM PLO_SECURITE_DE_SURFACE WHERE PER_NUM='.$_GET['per_num']);
        if(count($secu)>0)
            $secu = 1;
        else
            $secu = 0;


        if (empty($plongeur))
            header('location: /plongeur');

        $this->edit($plongeur);

        (new View('plongeur/plongeur_show/plongeur_show_index'))->generate([
            'plongeur' => $plongeur,
            'allAptitudes' => $this->aptitudeManager->getAll(),
            'securite' => $secu,
            'directeur' => $dir
        ]);
    }

    private function edit($plongeur)
    {


        if ( isset($_POST['submitEDITER']) )
            $this->verification($plongeur);

    }

    private function add()
    {
        if ( isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['aptitude']) ) {

            if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['aptitude'])) {
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $certif = $_POST['certificat'];
                $prenom = traitementPrenom($prenom);
                $nom = traitementNom($nom);
                if(!($nom==false) && !($prenom==false)) {
                    $plongeur[] = new Plongeur([]);
                    $personne[] = new Personne([
                        'PER_NOM' => traitementNom($nom),
                        'PER_PRENOM' => traitementPrenom($prenom),
                        'PER_DATE_CERTIF_MED' => $certif
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



    private function verification($plongeur, $add = false)
    {
        if ( $add || (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['aptitude'])) ) {

                if ($add || (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['aptitude']))) {
                    $nom = $_POST['nom'];
                    $prenom = $_POST['prenom'];
                    $aptitude = $_POST['aptitude'];
                    $dateCertificat = $_POST['certificat'];

                    $personnes = $this->personneManager->getAll();

                    $nbPersonnes = count($personnes);

                    $i = 0;
                    if(!$add) {
                        // Si le prénom ou le nom a été modifié
                        if ($nom != $plongeur[0]->getPersonne()[0]->getPerNom() || $prenom != $plongeur[0]->getPersonne()[0]->getPerPrenom() || $add)
                            while (($nom != $personnes[$i]->getPerNom() || $prenom != $personnes[$i]->getPerPrenom()) && (++$i < $nbPersonnes)) ;
                        else
                            $i = $nbPersonnes;
                    }
                    else{
                        if($nbPersonnes!=0)
                            while (($nom != $personnes[$i]->getPerNom() || $prenom != $personnes[$i]->getPerPrenom()) && (++$i < $nbPersonnes)) ;
                    }

                    if ($i == $nbPersonnes) {
                        $nom = traitementNom($nom);
                        $prenom = traitementPrenom($prenom);
                        if(!($nom==false) && !($prenom==false)) {
                            $plongeur[0]->getPersonne()[0]->setPerNom($nom);
                            $plongeur[0]->getPersonne()[0]->setPerPrenom($prenom);

                            $aptitudeObject = $this->aptitudeManager->getOne(['APT_CODE' => $aptitude]);

                            if (!is_null($aptitudeObject))
                                if ($add)
                                    $plongeur[0]->setAptitude($aptitudeObject);
                            $plongeur[0]->setAptCode($aptitude);

                            $plongeur[0]->getPersonne()[0]->setPerDateCertifMed($dateCertificat);

                            $this->plongeurManager->update($plongeur, $add);
                            if ($add) $plongeur = $this->personneManager->getOne([
                                'PER_NOM' => $nom,
                                'PER_PRENOM' => $prenom
                            ]);
                            if(!$add) {
                                $dir = DataBase::$db->LireDonnees('SELECT * FROM PLO_DIRECTEUR WHERE PER_NUM=' . $_GET['per_num']);

                                if (count($dir) > 0)
                                    $dir = 1;
                                else {
                                    $dir = 0;
                                }


                                $secu = DataBase::$db->LireDonnees('SELECT * FROM PLO_SECURITE_DE_SURFACE WHERE PER_NUM=' . $_GET['per_num']);
                                if (count($secu) > 0)
                                    $secu = 1;
                                else
                                    $secu = 0;


                                if (isset($_POST['directeur']) && $dir == 0)
                                    $this->plongeurManager->addDirector($plongeur[0]->getPerNum());
                                else if ($dir == 1 && !(isset($_POST['directeur'])))
                                    $this->plongeurManager->removeDirector($plongeur[0]->getPerNum());

                                if (isset($_POST['securite']) && $secu == 0)
                                    $this->plongeurManager->addSecurite($plongeur[0]->getPerNum());
                                else if ($secu == 1 && !(isset($_POST['securite'])))
                                    $this->plongeurManager->removeSecurite($plongeur[0]->getPerNum());

                            }
                            else{
                                if (isset($_POST['directeur']))
                                    $this->plongeurManager->addDirector($plongeur[0]->getPerNum());
                                if (isset($_POST['securite']))
                                    $this->plongeurManager->addSecurite($plongeur[0]->getPerNum());
                            }

                            if ($add) header('location: /plongeur');
                            else header('location: /plongeur/show/&per_num='.$_GET['per_num']);
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
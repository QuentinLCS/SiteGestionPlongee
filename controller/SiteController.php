<?php

require_once('_ControllerClass.php');


class SiteController extends _ControllerClass
{

    private $siteManager;

    public function __construct($url)
    {
        $this->siteManager= new SiteManager();
        $urlSize = parent::__construct($url);

        if ($urlSize > 1)
            if($url[1] == 'edit')
                $this->edit();
            else if($url[1] == 'delete')
                $this->delete();
            else
                throw new Exception('Page introuvable');
    }

    public function index()
    {
        $this->add();

        $searchedSites = null;

        if (!empty($_POST['searchNom'])) {
            $search['nom'] = $_POST['searchNom'];
            $searchedSites = $this->siteManager->getSearchResult($search);
        }


        (new View('site/site_index'))->generate([
            'allSites' => $this->siteManager->getAll(),
            'searchedSites' => $searchedSites
        ]);
    }

    public function add()
    {
        if ( isset($_POST['submit']) ) {

            $this->verificationCreation();
        }
    }

    public function edit()
    {

        if (empty($_GET['sit_num']))
            header('location: /site');

        $site = $this->siteManager->getOne([
            'SIT_NUM' => $_GET['sit_num']]);

        if (empty($site))
            header('location: /site');

        if ( isset($_POST['submit']) )
            $this->verificationModif($site);

        (new View('site/site_show/site_show_index'))->generate([
            'site' => $site
        ]);
    }

    /**
     * @return SiteManager
     */
    public function verificationModif($site)
    {
        if ( !empty($_POST['nom']) && !empty($_POST['localisation']) ) {
            $nom = $_POST['nom'];
            $localisation = $_POST['localisation'];
           $sites = $this->siteManager->getAll();
           $nbSites = count($sites);

           $i =0;


            if ($nom != $site[0]->getSitNom() || $localisation != $site[0]->getSitLocalisation())
                while (($nom != $sites[$i]->getSitNom() || $localisation != $sites[$i]->getSitLocalisation()) && ++$i < $nbSites) ;
            else
                $i = $nbSites;

            if ($i == $nbSites) {
                $site[0]->setSitNom($nom);
                $site[0]->setSitLocalisation($localisation);
                $this->siteManager->update($site);
                header('location: /site');
            } else
                $_POST['errorSiteAdd'] = 'Site déjà enregistrée.';
        }
    }

    public function verificationCreation()
    {
        if ( !empty($_POST['nom']) && !empty($_POST['localisation']) ) {
            $nom = $_POST['nom'];
            $localisation = $_POST['localisation'];
            $sites = $this->siteManager->getAll();
            $nbSites = count($sites);

            $i =0;
            if($nbSites != 0)
             while (($nom != $sites[$i]->getSitNom() || $localisation != $sites[$i]->getSitLocalisation()) && ++$i < $nbSites) ;

            if ($i == $nbSites) {
                    $data = array(
                        'SIT_NOM' => $nom,
                        'SIT_LOCALISATION' => $localisation
                    );
                    $site = new Site($data);
                    $this->siteManager->add($site);
                    header('location: /site');

            } else
                $_POST['errorSiteAdd'] = 'Site déjà enregistrée.';
        }
        else{

        }
    }

    public function delete(){
        if (empty($_GET['sit_num']))
            header('location: /site');

        $site = $this->siteManager->getOne([
            'SIT_NUM' => $_GET['sit_num']]);

        if (empty($site))
            header('location: /site');

        if ( isset($_POST['submit']) ) {
            $this->siteManager->delete($site);
            header('location: /site');
        }

        (new View('site/site_removeform'))->generate([
            'site' => $site,
        ]);
    }
}
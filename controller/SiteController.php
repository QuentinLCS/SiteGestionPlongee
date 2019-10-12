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
            else
                throw new Exception('Page introuvable');
    }

    public function index()
    {
        $this->add();

        (new View('site/site_index'))->generate([
            'allSites' => $this->siteManager->getAll()
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

        if (!isset($_GET['sit_num']))
            header('location: '.URL.'/site');

        $site = $this->siteManager->getOne([
            'SIT_NUM' => $_GET['sit_num']]);

        if (is_null($site))
            header('location: '.URL.'/plongeur');

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
                header('location: '.URL.'/site');
            } else
                echo 'Site déjà enregistrée.';
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

            while (($nom != $sites[$i]->getSitNom() || $localisation != $sites[$i]->getSitLocalisation()) && ++$i < $nbSites) ;

            if ($i == $nbSites) {
                $data = array(
                    'SIT_NUM'  => ($nbSites+1),
                    'SIT_NOM' => $nom,
                    'SIT_LOCALISATION' => $localisation
                );
                $site = new Site($data);
                $this->siteManager->add($site);
                header('location: '.URL.'/site');
            } else
                echo 'Site déjà enregistrée.';
        }
    }
}
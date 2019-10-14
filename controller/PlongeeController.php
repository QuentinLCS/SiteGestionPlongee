<?php

require_once('_ControllerClass.php');

class PlongeeController extends _ControllerClass
{
    private $plongeeManager;
    private $palanquee;
    private $site;
    private $bateau;
    private $plongeur;

    public function __construct($url)
    {
        $this->plongeeManager = new PlongeeManager();
        $this->palanquee = new PalanqueeManager();
        $this->bateau = new EmbarcationManager();
        $this->plongeur = new PlongeurManager();
        $this->site = new SiteManager();

        $urlSize = parent::__construct($url);

        if ($urlSize > 1)
            if($url[1] == 'show')
                $this->show();
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

        $searchedPlongees = null;

        if ( isset($_POST['search']) ) {

            if (!empty($_POST['searchDate']))
                $search['date'] = $_POST['searchDate'];

            if (!empty($_POST['searchPeriode']))
                $search['periode'] = $_POST['searchPeriode'];

            if (!empty($_POST['searchDate']) || !empty($_POST['searchPeriode']))
                $searchedPlongees = $this->plongeeManager->getSearchResult($search);

        }

        (new View('plongee/plongee_index'))->generate([
            'allPlongees' => $this->plongeeManager->getAll(),
            'searchedPlongees' => $searchedPlongees
        ]);
    }

    public function show()
    {
        if (!isset($_GET['plo_date']) || !isset($_GET['plo_mat_mid_soi']))
            header('location: /plongee');

        $plongee = $this->plongeeManager->getOne([
            'PLO_DATE' => $_GET['plo_date'],
            'PLO_MAT_MID_SOI' => $_GET['plo_mat_mid_soi']]);

        $palanquee = $this->palanquee->getPlongeePalanquee("PLO_PLONGEE");
        $bateau = $this->bateau->getEmbarcationPlongee("PLO_PLONGEE");
        $plongeur = $this->plongeur->getPlongeurPlongee("PLO_PLONGEE");
        $site = $this->site->getSitePlongee("PLO_PLONGEE");

        if (is_null($plongee))
            header('location: /plongee');

        if ( isset($_POST['submit']) )
            $this->verification($plongee);

        (new View('plongee/plongee_show/plongee_show_index'))->generate([
            'plongee' => $plongee,
            'palanquee' => $palanquee,
            'bateau' => $bateau,
            'plongeur' => $plongeur,
            'site' => $site
        ]);
    }

    private function edit()
    {

    }

    private function add()
    {
        // Ajout d'une plongee
    }

    private function verification($plongeur)
    {
        header('location: /plongee');
    }
}
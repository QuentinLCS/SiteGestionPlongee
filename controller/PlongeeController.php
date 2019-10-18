<?php

require_once('_ControllerClass.php');

class PlongeeController extends _ControllerClass
{
    private $plongeeManager;
    private $siteManager;
    private $embarcationManager;
    private $personneManager;
    private $palanqueeManager;
    private $plongeurManager;

    public function __construct($url)
    {
        $this->plongeeManager = new PlongeeManager();
        $this->siteManager = new SiteManager();
        $this->embarcationManager =  new EmbarcationManager();
        $this->personneManager = new PersonneManager();
        $this->palanqueeManager = new PalanqueeManager();
        $this->plongeurManager = new PlongeurManager();

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
            'searchedPlongees' => $searchedPlongees,
            'allSite' => $this->siteManager->getAll(),
            'allEmbarcation' => $this->embarcationManager->getAll()
        ]);
    }

    public function show()
    {
        if (!isset($_GET['plo_date']) || !isset($_GET['plo_mat_mid_soi']))
            header('location: /plongee');

        $plongee = $this->plongeeManager->getOne([
            'PLO_DATE' => $_GET['plo_date'],
            'PLO_MAT_MID_SOI' => $_GET['plo_mat_mid_soi']]);

        $palanquee = $this->palanqueeManager->getPlongeePalanquee("PLO_PLONGEE");
        $bateau = $this->embarcationManager->getEmbarcationPlongee("PLO_PLONGEE");
        $plongeur = $this->plongeurManager->getPlongeurPlongee("PLO_PLONGEE");
        $site = $this->siteManager->getSitePlongee("PLO_PLONGEE");

        if (is_null($plongee))
            header('location: /plongee');

        if ( isset($_POST['submit']) )
            $this->verification($plongee);

        elseif ($_GET['page']=='palanquee')
        {
            (new View('plongee/plongee_show/plongee_show_palanquee'))->generate([
                'plongee' => $plongee,
                'palanquee' => $palanquee
            ]);
        }
        elseif ($_GET['page']=='bateaux')
        {
            (new View('plongee/plongee_show/plongee_show_bateaux'))->generate([
                'plongee' => $plongee,
                'bateau' => $bateau,
            ]);
        }
        elseif ($_GET['page']=='site')
        {
            (new View('plongee/plongee_show/plongee_show_site'))->generate([
                'plongee' => $plongee,
                'site' => $site
            ]);
        }
        elseif ($_GET['page']=='plongeurs')
        {
            (new View('plongee/plongee_show/plongee_show_plongeurs'))->generate([
                'plongee' => $plongee,
                'plongeur' => $plongeur
            ]);
        }
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
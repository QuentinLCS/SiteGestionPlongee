<?php

require_once('_ControllerClass.php');

class PlongeeController extends _ControllerClass
{
    private $plongeeManager;
    private $siteManager;
    private $embarcationManager;
    private $personneManager;


    public function __construct($url)
    {
        $this->plongeeManager = new PlongeeManager();
        $this->siteManager = new SiteManager();
        $this->embarcationManager =  new EmbarcationManager();
        $this->personneManager = new PersonneManager();

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

        if (is_null($plongee))
            header('location: /plongee');

        if ( isset($_POST['submit']) )
            $this->verification($plongee);

        (new View('plongee/plongee_show/plongee_show_index'))->generate([
            'plongee' => $plongee
        ]);
    }

    private function edit()
    {

    }

    private function add()
    {
        if (isset($_POST["date"]) && isset($_POST["periode"]) && isset($_POST["site"]) && isset($_POST["embarcation"]) && isset($_POST["directeur"]) && isset($_POST["securite"]) && isset($_POST["submit"])) {
            $date = $_POST["date"];
            $periode = strtoupper($_POST["periode"]);
            $siteNum = intval($_POST["site"], 10);
            $embNum = intval($_POST["embarcation"], 10);
            $directeurNum = intval($_POST["directeur"], 10);
            $securiteNum = intval($_POST["securite"], 10);
            $envoyer = $_POST["submit"];

            //Récupère l'effactif de plongeur depuis le formulaire
            if (isset($_POST["effectifP"]) && $_POST["effectifP"] != "") {
                $effectifP = intval($_POST["effectifP"], 10);
            } else {
                $effectifP = "NULL";
            }

            //Récupère l'effactif sur le bateau depuis le formulaire
            if (isset($_POST["effectifB"]) && $_POST["effectifB"] != "") {
                $effectifB = intval($_POST["effectifB"], 10);
            } else {
                $effectifB = "NULL";
            }

            $plongee[] = new Plongee([
                'PLO_DATE' => $date,
                'PLO_MAT_MID_SOI' => $periode,
                'SIT_NUM' => $siteNum,
                'EMB_NUM' => $embNum,
                'PER_NUM_DIR' => $directeurNum,
                'PER_NUM_SECU' => $securiteNum,
                'PLO_EFFECTIF_PLONGEURS' => $effectifP,
                'PLO_EFFECTIF_BATEAU' => $effectifB
            ]);

            $this->plongeeManager->update($plongee, true);

        } else {
            echo 'Tous les champs ne sont pas remplis.';
            var_dump($_POST);
        }
    }

    private function verification($plongeur)
    {
        header('location: /plongee');
    }
}
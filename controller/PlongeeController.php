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

        if ($urlSize > 1) {
            if ($url[1] == 'show' && $url[2] == 'editPal')
                $this->editPal();
            else if($url[1] == 'show' && $url[2] == 'deletePal')
                $this->deletePal();
            else if ($url[1] == 'show' && $url[2] =='removePlo')
                $this->removePlo();
            else if ($url[1] == 'show')
                $this->show();
            else if ($url[1] == 'delete')
                $this->delete();
            else
                throw new Exception('Page introuvable');
        }
    }

    /**
     * Fonction chargée au chargement de la page.
     * @throws Exception
     */
    public function index()
    {
        if (isset($_POST['submitPLO']))
            $this->addPlongee();

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
            'allEmbarcation' => $this->embarcationManager->getAll(),
            'allDirecteur' => $this->personneManager->getAllDirecteur(),
            'allSecurite' => $this->personneManager->getAllSecurite()
        ]);
    }

    public function show()
    {
        if (!isset($_GET['plo_date']) || !isset($_GET['plo_mat_mid_soi']))
            header('location: /plongee');
        //TODO faire attention page

        $plongee = $this->plongeeManager->getOne([
            'PLO_DATE' => $_GET['plo_date'],
            'PLO_MAT_MID_SOI' => $_GET['plo_mat_mid_soi']
        ]);

        $palanquee = $this->palanqueeManager->getPlongeePalanquee($plongee[0]->getPloDate(),$plongee[0]->getPloMatMidSoi());
        $bateau = $this->embarcationManager->getEmbarcationPlongee($plongee[0]->getEmbNum());
        $plongeurs = $this->plongeurManager->getPlongeurPlongee($plongee[0]->getPloDate(),$plongee[0]->getPloMatMidSoi());
        $site = $this->siteManager->getSitePlongee($plongee[0]->getSite()[0]->getSitNum());

        if (is_null($plongee))
            header('location: /plongee');

        if ( isset($_POST['submit']) )
            $this->verification($plongee);
        if(isset($_POST['submitSite']))
        {
            $this->edit('Site',$plongee);
        }
        elseif (isset($_POST['submitEmbar']))
        {
            $this->edit('Embar',$plongee);
        }
        elseif (isset($_POST["submitPLONGEUR"])) {
            $this->edit("Plongeur", $plongee);
        }

        elseif(isset($_POST['submitPeriode']))
        {
            $this->edit('peri',$plongee);
        }
        elseif(isset($_POST['submitDate']))
        {
            $this->edit('date',$plongee);
        }
        $this->addPalanquee();

        (new View('plongee/plongee_show/plongee_show_index'))->generate([
            'plongee' => $plongee,
            'allSite' => $this->siteManager->getAll(),
            'allEmbarcation' => $this->embarcationManager->getAll(),
            'allPlongeurs' => $this->plongeurManager->getAll(),
            'bateau' => $bateau,
            'plongeurs' => $plongeurs,
            'palanquees' => $palanquee,
            'site' => $site
        ]);
    }



    private function edit($value,$base)
    {
        if($value=="Site")
        {
            if(isset($_POST["siteNum"]))
            {
                $update=$this->siteManager->getOne([
                    'SIT_NUM'=>intval($_POST['siteNum'])
                ]);
                $base[0]->setSitNum(intval($update[0]->getSitNum()));
                $this->plongeeManager->update($base,false);
            }
        }
        elseif ($value=="Embar")
        {
            if(isset($_POST["embar"]))
            {
                $update=$this->embarcationManager->getOne([
                    'EMB_NUM'=>intval($_POST['embar'])
                ]);
                $base[0]->setEmbNum(intval($update[0]->getEmbNum()));
                $this->plongeeManager->update($base,false);
            }
        }
        elseif ($value=="peri")
        {
            if(isset($_POST['selectPeriode']))
            {
                $suppPal=$this->palanqueeManager->getOne([
                    'PLO_DATE' => $base[0]->getPloDate(),
                    'PLO_MAT_MID_SOI' => $base[0]->getPloMatMidSoi()
                ]);
                foreach ($suppPal as $pal)
                {
                    $pal->setPloMatMidSoi($_POST['selectPeriode']);
                    $tab[0]=$pal;
                    $this->palanqueeManager->delete($tab);
                }
                $this->plongeeManager->delete($base);
                $base[0]->setPloMatMidSoi($_POST['selectPeriode']);
                $this->plongeeManager->update($base,true);
                foreach ($suppPal as $pal)
                {
                    $tab[0]=$pal;
                    $this->palanqueeManager->update($tab,true);
                }
            }
        }
        elseif ($value=="date")
        {
            if(isset($_POST['date']))
            {
                $suppPal=$this->palanqueeManager->getOne([
                    'PLO_DATE' => $base[0]->getPloDate(),
                    'PLO_MAT_MID_SOI' => $base[0]->getPloMatMidSoi()
                ]);
                foreach ($suppPal as $pal)
                {
                    $pal->setPloDate($_POST['date']);
                    $tab[0]=$pal;
                    $this->plongeeManager->delete($tab);
                }
                $this->plongeeManager->delete($base);
                $base[0]->setPloDate($_POST['date']);
                $this->plongeeManager->update($base,true);
                foreach ($suppPal as $pal)
                {
                    $tab[0]=$pal;
                    $this->palanqueeManager->update($tab,true);
                }
            }
        }
        if ($value=="Plongeur") {
            $date = $_GET["plo_date"];
            $periode = $_GET["plo_mat_mid_soi"];
            $numPal = $_POST["palanquee"];
            $numPers = $_POST["plongeur"];

            $concerner = [
                'PLO_DATE' => $date,
                'PLO_MAT_MID_SOI' => $periode,
                'PAL_NUM' => $numPal,
                'PER_NUM' => $numPers
            ];

            $this->palanqueeManager->updatePlongeurs($concerner);
            header('location: /plongee/show/&plo_date='.$_GET['plo_date'].'&plo_mat_mid_soi='.$_GET['plo_mat_mid_soi']);
        }
    }

    private function addPlongee()
    {
        //Vérifie si le formulaire et bien un formulaire d'ajout de plongée
        if (isset($_POST["submitPLO"])) {
            if (isset($_POST["date"]) && isset($_POST["periode"]) && isset($_POST["site"]) && isset($_POST["embarcation"]) && isset($_POST["directeur"]) && isset($_POST["securite"])) {
                $date = $_POST["date"];
                $periode = ($_POST["periode"]);
                $siteNum = intval($_POST["site"], 10);
                $embNum = intval($_POST["embarcation"], 10);
                $directeurNum = intval($_POST["directeur"], 10);
                $securiteNum = intval($_POST["securite"], 10);
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
                    'PLO_EFFECTIF_BATEAU' => $effectifB,
                    'PLO_ETAT'=> "Creee"
                ]);
                $this->plongeeManager->update($plongee, true);
            } else {
                echo 'Tous les champs ne sont pas remplis.';
                var_dump($_POST);
            }
        }
    }

    public function addPalanquee() {
        if (isset($_POST["submitPAL"]) && isset($_POST["heureD"]) && isset($_POST["profondeurP"]) && isset($_POST["tempsP"])) {
            if ($_POST["heureD"] !="" && $_POST["profondeurP"] != "" && $_POST["tempsP"] != "")
            $date = $_GET["plo_date"];
            $periode = $_GET["plo_mat_mid_soi"];
            $heureD = $_POST["heureD"];
            $heureA = "NULL";
            $tempsP = intval($_POST["tempsP"]);
            $tempsR = "NULL";
            $profondeurP = doubleval($_POST["profondeurP"]);
            $profondeurR  = "NULL";

            $allPal = $this->palanqueeManager->getPlongeePalanquee($date,$periode);
            $i = 1;
            $palNum = null;
            foreach ( $allPal as $pal ) {
                if (intval($pal->getPalNum()) != ($i)) {
                    if (!isset($palNum)) {
                        $palNum = $i;
                    }
                }
                $i++;
            }
            if  (!isset($palNum)) {
                $palNum = $i;
            }

            // Récupère l'heure d'arrivée depuis le formulaire reçu
            if (isset($_POST["heureA"]) && $_POST["heureA"] !="") {
                $heureA = $_POST["heureA"];
            }

            // Récupère le temps réel depuis le formulaire reçu
            if (isset($_POST["tempsR"]) && $_POST["tempsR"] != "") {
                $tempsR = intval($_POST["tempsR"]);
            }

            // Récupère la profondeur réel depuis le formulaire reçu
            if (isset($_POST["profondeurR"]) && $_POST["profondeurR"] != "") {
                $profondeurR = intval($_POST["profondeurR"]);
            }

            $palanqueeObj[] = new Palanquee([
                'PLO_DATE' => $date,
                'PLO_MAT_MID_SOI' => $periode,
                'PAL_NUM' => $palNum,
                'PAL_PROFONDEUR_MAX' => $profondeurP,
                'PAL_DUREE_MAX' => $tempsP,
                'PAL_HEURE_IMMERSION' => $heureD,
                'PAL_HEURE_SORTIE_EAU' => $heureA,
                'PAL_PROFONDEUR_REELLE' => $profondeurR,
                'PAL_DUREE_FOND' => $tempsR
            ]);
            $this->palanqueeManager->update($palanqueeObj, true);
            $nombrePalanquee=$this->palanqueeManager->getPlongeurEffecif($date,$periode);
            $nombrePlongeur=$this->plongeeManager->getEffectifPlongeur($date,$periode);
            $plongee=$this->plongeeManager->getOne([
                'PLO_DATE' => $_GET['plo_date'],
                'PLO_MAT_MID_SOI' => $_GET['plo_mat_mid_soi']
            ]);
            $plongee[0]->setPloNbPalanquees(intval($nombrePalanquee[0]['count(*)']));
            $plongee[0]->setPloEtat("Parametree");
            $plongee[0]->setPloEffectifPlongeurs(intval($nombrePlongeur[0]['count(PLO_CONCERNER.PER_NUM)']));
            $plongee[0]->setPloEffectifBateau(1);
            $this->plongeeManager->update($plongee,false);
        }

    }

    public function delete(){
        if (!isset($_GET['plo_date']) || !isset($_GET['plo_mat_mid_soi']))
            header('location: /plongee');

        $plongee = $this->plongeeManager->getOne([
            'PLO_DATE' => $_GET['plo_date'],
            'PLO_MAT_MID_SOI' => $_GET['plo_mat_mid_soi']]);


        if (is_null($plongee))
            header('location: /plongee');

        if ( isset($_POST['submit']) ){
            $this->plongeeManager->delete($plongee);
            header('location: /plongee');
        }

        (new View('plongee/plongee_removeform'))->generate([
            'plongee' => $plongee,
        ]);
    }

    private function verification($plongeur)
    {
        header('location: /plongee');
    }

    private function editPal(){

        if (empty($_GET['plo_date']) || empty($_GET['plo_mat_mid_soi']) || empty($_GET['pal_num']) )
            header('location: /plongee');

        $palanquee = $this->palanqueeManager->getOne([
            'PLO_DATE' => $_GET['plo_date'],
            'PLO_MAT_MID_SOI' => $_GET['plo_mat_mid_soi'],
            'PAL_NUM' => $_GET['pal_num']]);

        if (empty($palanquee))
            header('location: /plongee');

        if ( isset($_POST['submit']) ){
            if(!empty($_POST["profondeurMax"]) && !empty($_POST["DureeMax"]) && !empty($_POST["HImmersion"]) ) {

                $profondeurMax = $_POST["profondeurMax"];
                $dureeMax = $_POST["DureeMax"];
                $HImmersion = $_POST["HImmersion"];

                $palanquee[0]->setPalProfondeurMax($profondeurMax);
                $palanquee[0]->setPalDureeMax($dureeMax);
                $palanquee[0]->setPalHeureImmersion($HImmersion);

                if (!empty($_POST["HSortie"]) && !empty($_POST["ProfondeurReelle"]) && !empty($_POST["DureeFond"])) {
                    $HSortie = $_POST["HSortie"];
                    $ProfondeurReelle = $_POST["ProfondeurReelle"];
                    $DureeFond = $_POST["DureeFond"];
                    $palanquee[0]->setPalHeureSortieEau($HSortie);
                    $palanquee[0]->setPalProfondeurReelle($ProfondeurReelle);
                    $palanquee[0]->setPalDureeFond($DureeFond);
                }

                $this->palanqueeManager->update($palanquee);

                header('location: /plongee/show/&plo_date='.$_GET['plo_date'].'&plo_mat_mid_soi='.$_GET['plo_mat_mid_soi'].'&page=palanquee');
            }
            else{
                header('location: /plongee/show/&plo_date='.$_GET['plo_date'].'&plo_mat_mid_soi='.$_GET['plo_mat_mid_soi'].'&page=palanquee');
            }
        }


        (new View('plongee/plongee_show/plongee_show_palanquee/plongee_show_palanquee_editform'))->generate([
            'palanquee' => $palanquee,

        ]);
    }

    private function removePlo() {
        if (!isset($_GET['plo_date']) || !isset($_GET['plo_mat_mid_soi']) || !isset($_GET['pal_num']) || !isset($_GET['per_num']) )
            header('location: /plongee');

        $palanquee = [
            'plo_date' => $_GET['plo_date'],
            'plo_mat_mid_soi' => $_GET['plo_mat_mid_soi'],
            'pal_num' => $_GET['pal_num'],
            'per_num' => $_GET['per_num']
        ];

        if ( isset($_POST['removePLONGEUR']) ){
            $this->plongeeManager->deleteConcerner($palanquee);
            header('location: /plongee/show/&plo_date='.$_GET['plo_date'].'&plo_mat_mid_soi='.$_GET['plo_mat_mid_soi']);
        }

        (new View('plongee/plongee_show/plongee_show_plongeurs/plongee_show_plongeurs_removeform'))->generate([
            'palanquee' => $palanquee,
        ]);
    }

    private function deletePal()
    {
        if (empty($_GET['plo_date']) || empty($_GET['plo_mat_mid_soi']) || empty($_GET['pal_num']))
            header('location: /plongee');

        $palanquee = $this->palanqueeManager->getOne([
            'PLO_DATE' => $_GET['plo_date'],
            'PLO_MAT_MID_SOI' => $_GET['plo_mat_mid_soi'],
            'PAL_NUM' => $_GET['pal_num']]);

        if (empty($palanquee))
            header('location: /plongee');

        if ( isset($_POST['submit']) ){
            $this->palanqueeManager->delete($palanquee);
            header('location: /plongee/show/&plo_date='.$_GET['plo_date'].'&plo_mat_mid_soi='.$_GET['plo_mat_mid_soi'].'&page=palanquee');
        }

        (new View('plongee/plongee_show/plongee_show_palanquee/plongee_show_palanquee_removeform'))->generate([
            'palanquee' => $palanquee,
        ]);
    }
}



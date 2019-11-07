<?php

require_once('_ControllerClass.php');
require_once('model/utils/DateFomater.php');

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
            if ($url[1] == 'show' && $url[2] == 'editPal' && $url[3] == 'removePlo')
                $this->removePlo();
            else if ($url[1] == 'show' && $url[2] == 'editPal')
                $this->editPal();
            else if($url[1] == 'show' && $url[2] == 'deletePal')
                $this->deletePal();
            else if ($url[1] == 'show' && $url[2] == 'validerPlongee')
                $this->validerPlongee();
            else if ($url[1] == 'download')
                $this->download();
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

    public function download()
    {

        $plongee = $this->verifierPlongee();

        $palanquee = $this->palanqueeManager->getPlongeePalanquee($plongee[0]->getPloDate(),$plongee[0]->getPloMatMidSoi());

        $plongeurs = null;
        foreach ($palanquee as $pal)
            $plongeurs[] = $this->plongeurManager->getPlongeurPlongee($_GET['plo_date'],$_GET['plo_mat_mid_soi'],$pal->getPalNum());

        (new View('plongee/plongee_download'))->generate([
            'plongee' => $plongee,
            'palanquees' => $palanquee,
            'plongeurs' => $plongeurs
        ], true);
    }

    public function show()
    {

        $plongee = $this->verifierPlongee();

        $palanquee = $this->palanqueeManager->getPlongeePalanquee($plongee[0]->getPloDate(),$plongee[0]->getPloMatMidSoi());
        $bateau = $this->embarcationManager->getEmbarcationPlongee($plongee[0]->getEmbNum());
        $site = $this->siteManager->getSitePlongee($plongee[0]->getSite()[0]->getSitNum());

        if ( isset($_POST['submit']) )
            $this->verification($plongee);

        if(isset($_POST['submitSite']))
            $this->edit('Site',$plongee);

        elseif (isset($_POST['submitEmbar']))
            $this->edit('Embar',$plongee);

        elseif(isset($_POST['submitPeriode']))
            $this->edit('peri',$plongee);

        elseif(isset($_POST['submitDate']))
            $this->edit('date',$plongee);

        elseif (isset($_POST['submitDirecteur']))
            $this->edit('dire',$plongee);

        elseif (isset($_POST['submitSurface']))
            $this->edit('surf',$plongee);

        $this->addPalanquee();

        (new View('plongee/plongee_show/plongee_show_index'))->generate([
            'plongee' => $plongee,
            'allSite' => $this->siteManager->getAll(),
            'allEmbarcation' => $this->embarcationManager->getAll(),
            'allPlongeurs' => $this->plongeurManager->getAll(),
            'bateau' => $bateau,
            'palanquees' => $palanquee,
            'site' => $site,
            'allDirecteur' => $this->personneManager->getAllDirecteur(),
            'allSecuriteSurface' => $this->personneManager->getAllSecurite()
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
                header('location: /plongee/show/&plo_date='.$_GET['plo_date'].'&plo_mat_mid_soi='.$_GET['plo_mat_mid_soi']);
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
                header('location: /plongee/show/&plo_date='.$_GET['plo_date'].'&plo_mat_mid_soi='.$_GET['plo_mat_mid_soi']);
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

                $concernerOld=$this->palanqueeManager->getConcerner($base);

                foreach ($suppPal as $pal)
                {
                    $pal->setPloMatMidSoi($_POST['selectPeriode']);
                    if($pal->getPalDureeFond()==null)
                        $pal->setPalDureeFond('NULL');

                    if($pal->getPalProfondeurReelle()==null)
                        $pal->setPalProfondeurReelle('NULL');

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

                foreach ($concernerOld as $concerner)
                {
                    $concerner['PLO_DATE']=$base[0]->getPloDate();
                    $concerner['PLO_MAT_MID_SOI']=$base[0]->getPloMatMidSoi();
                    $this->palanqueeManager->setConcerner($concerner);
                }

                header('location: /plongee/show/&plo_date='.$_GET['plo_date'].'&plo_mat_mid_soi='.$_POST['selectPeriode']);
            }
        }
        elseif ($value=="date")
        {
            if(isset($_POST['date']) && $this->verifierDate($_POST['date']))
            {
                $suppPal=$this->palanqueeManager->getOne([
                    'PLO_DATE' => $base[0]->getPloDate(),
                    'PLO_MAT_MID_SOI' => $base[0]->getPloMatMidSoi()
                ]);

                $concernerOld=$this->palanqueeManager->getConcerner($base);

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
                    if($pal->getPalDureeFond()==null)
                    {
                        $pal->setPalDureeFond('NULL');
                    }
                    if($pal->getPalProfondeurReelle()==null)
                    {
                        $pal->setPalProfondeurReelle('NULL');
                    }
                    $tab[0]=$pal;
                    $this->palanqueeManager->update($tab,true);
                }

                foreach ($concernerOld as $concerner)
                {
                    $concerner['PLO_DATE']=$base[0]->getPloDate();
                    $concerner['PLO_MAT_MID_SOI']=$base[0]->getPloMatMidSoi();
                    $this->palanqueeManager->setConcerner($concerner);
                }

                header('location: /plongee/show/&plo_date='.$_POST['date'].'&plo_mat_mid_soi='.$_GET['plo_mat_mid_soi']);
            }
        }
        elseif ($value=="dire")
        {
            if(isset($_POST["selectDirecteur"]))
            {
                $base[0]->setDirecteur(intval($_POST["selectDirecteur"]));
                $this->plongeeManager->update($base,false);
                header('location: /plongee/show/&plo_date='.$_GET['plo_date'].'&plo_mat_mid_soi='.$_GET['plo_mat_mid_soi']);
            }
        }
        elseif ($value=="surf")
        {
            if(isset($_POST["selectSurface"]))
            {
                $base[0]->setSecurite(intval($_POST["selectSurface"]));
                $this->plongeeManager->update($base,false);
                header('location: /plongee/show/&plo_date='.$_GET['plo_date'].'&plo_mat_mid_soi='.$_GET['plo_mat_mid_soi']);
            }
        }
    }

    private function addPlongee()
    {
        //Vérifie si le formulaire et bien un formulaire d'ajout de plongée
        if (isset($_POST["submitPLO"])) {
            if (isset($_POST["date"]) && isset($_POST["periode"]) && isset($_POST["site"]) && isset($_POST["embarcation"]) && isset($_POST["directeur"]) && isset($_POST["securite"]) && isset($_POST["effectifB"]) && $this->verifierDate($_POST["date"])) {
                $date = $_POST["date"];
                $periode = ($_POST["periode"]);
                $siteNum = intval($_POST["site"], 10);
                $embNum = intval($_POST["embarcation"], 10);
                $directeurNum = intval($_POST["directeur"], 10);
                $securiteNum = intval($_POST["securite"], 10);
                $effectifB = "0";
                if ($_POST["effectifB"] != "") {
                    $effectifB = intval($_POST["effectifB"], 10);
                }
                $plongee[] = new Plongee([
                    'PLO_DATE' => $date,
                    'PLO_MAT_MID_SOI' => $periode,
                    'SIT_NUM' => $siteNum,
                    'EMB_NUM' => $embNum,
                    'PER_NUM_DIR' => $directeurNum,
                    'PER_NUM_SECU' => $securiteNum,
                    'PLO_EFFECTIF_PLONGEURS' => 0,
                    'PLO_EFFECTIF_BATEAU' => $effectifB,
                    'PLO_EFFECTIF_BATEAU' => $this->plongeeManager->getEffectifPlongeur($_POST["date"],$_POST["periode"])[0]['count(PLO_CONCERNER.PER_NUM)']+2,
                    'PLO_ETAT'=> "Creee"
                ]);

                if (empty($this->plongeeManager->getSearchResult(['date' => $date, 'periode'=>$periode]))) {
                    $this->plongeeManager->update($plongee, true);
                    header('location: /plongee/show/&plo_date='.$date.'&plo_mat_mid_soi='.$periode.'&page=palanquee');
                } else {
                    $_POST['errorPlongeeAdd'] = "Ajout d'une Plongee : Plongee déjà existante.";
                }
            } else
                $_POST['errorPlongeeAdd'] = "Ajout d'une Plongee: Données manquantes.";
        }
    }

    public function addPalanquee() {
        if (isset($_POST["submitPAL"]) && isset($_POST["profondeurP"]) && isset($_POST["tempsP"])) {
            if ($_POST["profondeurP"] != "" && $_POST["tempsP"] != "") {
                $date = $_GET["plo_date"];
                $periode = $_GET["plo_mat_mid_soi"];
                $heureD = $_POST["heureD"];
                $heureA = "NULL";
                $tempsP = intval($_POST["tempsP"]);
                $tempsR = "NULL";
                $profondeurP = doubleval($_POST["profondeurP"]);
                $profondeurR = "NULL";

                $allPal = $this->palanqueeManager->getPlongeePalanquee($date, $periode);
                $i = 1;
                $palNum = null;
                foreach ($allPal as $pal) {
                    if (intval($pal->getPalNum()) != ($i)) {
                        if (!isset($palNum)) {
                            $palNum = $i;
                        }
                    }
                    $i++;
                }
                if (!isset($palNum))
                    $palNum = $i;

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
            if  (!isset($palNum))
                $palNum = $i;


                // Récupère l'heure d'arrivée depuis le formulaire reçu
                if (isset($_POST["heureA"]) && $_POST["heureA"] != "")
                    $heureA = $_POST["heureA"];


                // Récupère le temps réel depuis le formulaire reçu
                if (isset($_POST["tempsR"]) && $_POST["tempsR"] != "")
                    $tempsR = intval($_POST["tempsR"]);


                // Récupère la profondeur réel depuis le formulaire reçu
                if (isset($_POST["profondeurR"]) && $_POST["profondeurR"] != "")
                    $profondeurR = intval($_POST["profondeurR"]);


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
                $this->updateEffectifPalanquee();
                header('location: /plongee/show/&plo_date=' . $_GET['plo_date'] . '&plo_mat_mid_soi=' . $_GET['plo_mat_mid_soi']);
            } else {
                $_POST['errorPalanqueeAdd'] = "Ajout d'une Palanquée : Données invalide";
            }
        } else {
            $_POST['errorPalanqueeAdd'] = "Ajout d'une Palanquée : Données manquantes";
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

        $plongeurs = $this->plongeurManager->getPlongeurPlongee($_GET['plo_date'],$_GET['plo_mat_mid_soi'],$_GET['pal_num'] );

        $plongee = $this->plongeeManager->getOne([
            'PLO_DATE' => $_GET['plo_date'],
            'PLO_MAT_MID_SOI' => $_GET['plo_mat_mid_soi'],
        ]);

        if (empty($palanquee))
            header('location: /plongee');

        if (isset($_POST["submitPLONGEUR"])) {

            $base = $this->verifierPlongee();

            if ($this->verifierPlongeurPalanquee()) {

                $nombre = $this->palanqueeManager->getNombreConcerner($base, intval($_GET['pal_num']));
                if ($nombre[0]['count(*)'] < 5) {
                    $date = $_GET["plo_date"];
                    $periode = $_GET["plo_mat_mid_soi"];
                    $numPal = $_GET['pal_num'];
                    $numPers = $_POST["plongeur"];

                    $concerner = [
                        'PLO_DATE' => $date,
                        'PLO_MAT_MID_SOI' => $periode,
                        'PAL_NUM' => $numPal,
                        'PER_NUM' => $numPers
                    ];

                    $plongee = $this->plongeeManager->getOne([
                        'PLO_DATE' => $date,
                        'PLO_MAT_MID_SOI' => $periode
                    ]);

                    if (($numPers == $plongee[0]->getDirecteur()[0]->getPerNum()) || ($numPers == $plongee[0]->getSecurite()[0]->getPerNum())) {
                        $_POST['errorPlongeur'] = 'Ce plongeur ne peut être ajouter à la Palanquée. (Directeur/Sécurité de Surface)';
                    }
                    /*elseif ()//TODO
                    {
                        $_POST['errorPlongeur'] = 'Ce plongeur ne peut être ajouter à la Palanquée. (existe déjà dans une autre palanquée)';
                    }*/
                    else {
                        $this->palanqueeManager->updatePlongeurs($concerner);
                        $plongee = $this->updateEffectifPlongeur();
                        $this->plongeeManager->update($plongee);
                        header('location: /plongee/show/editPal/&pal_num=' . $_GET['pal_num'] . '&plo_date=' . $_GET['plo_date'] . '&plo_mat_mid_soi=' . $_GET['plo_mat_mid_soi']);
                    }


                    /*
                     *
                    $plongeur = $this->personneManager->getOne([
                        'PER_NUM' => $numPers
                    ]);
                    if ($plongeur[0]->getPerActive() == 0) {
                        $plongeur[0]->setPerActive(1);
                        $this->personneManager->update($plongeur, false);
                    }
                    */
                } else {
                    $_POST['errorPlongeur'] = "Ajout d'un Plongeur : Nombre maximum de plongeurs atteint";
                }
            } else {
                $_POST['errorPlongeur'] = "Ajout d'un Plongeur : Ce Plongeur a déjà été ajouter";
            }
        }

        if ( isset($_POST['submit']) ){
            if(!empty($_POST["profondeurMax"]) && !empty($_POST["DureeMax"]) ) {

                $profondeurMax = $_POST["profondeurMax"];
                $dureeMax = $_POST["DureeMax"];

                $palanquee[0]->setPalProfondeurMax($profondeurMax);
                $palanquee[0]->setPalDureeMax($dureeMax);

                if (!empty($_POST["HImmersion"])) {
                    $HImmersion = $_POST["HImmersion"];
                    $palanquee[0]->setPalHeureSortieEau($HImmersion);
                }
                if (!empty($_POST["HSortie"])) {
                    $HSortie = $_POST["HSortie"];
                    $palanquee[0]->setPalHeureSortieEau($HSortie);
                }
                if (!empty($_POST["ProfondeurReelle"]))  {
                    $ProfondeurReelle = $_POST["ProfondeurReelle"];
                    $palanquee[0]->setPalProfondeurReelle($ProfondeurReelle);
                }
                if (!empty($_POST["DureeFond"])) {
                    $DureeFond = $_POST["DureeFond"];
                    $palanquee[0]->setPalDureeFond($DureeFond);
                }

                $this->palanqueeManager->update($palanquee);

                header('location: /plongee/show/editPal/&pal_num='.$_GET['pal_num'].'&plo_date='.$_GET['plo_date'].'&plo_mat_mid_soi='.$_GET['plo_mat_mid_soi']);
            }
            else{
                $_POST['errorPalanqueeEdit'] = "Modification Palanquée : Données Invalide";
            }
        }


        (new View('plongee/plongee_show/plongee_show_palanquee/plongee_show_palanquee_editform'))->generate([
            'palanquee' => $palanquee,
            'plongeurs' => $plongeurs,
            'plongee' => $plongee,
            'allActive' => $this->personneManager->getSearchResult(['inactive' => 1]),
            'allInactive' => $this->personneManager->getSearchResult(['inactive' => 0])
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
            $this->updateEffectifPlongeur();
            header('location: /plongee/show/editPal/&pal_num='.$_GET['pal_num'].'&plo_date='.$_GET['plo_date'].'&plo_mat_mid_soi='.$_GET['plo_mat_mid_soi']);
        }

        (new View('plongee/plongee_show/plongee_show_palanquee/plongee_show_plongeurs/plongee_show_plongeurs_removeform'))->generate([
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
            $this->updateEffectifPalanquee();
            $base=$this->updateEffectifPlongeur();
            if($this->verifierCompleter($base))
            {
                $base[0]->setPloEtat("Complete");
            }
            $this->plongeeManager->update($base,false);
            header('location: /plongee/show/&plo_date='.$_GET['plo_date'].'&plo_mat_mid_soi='.$_GET['plo_mat_mid_soi']);
        }

        (new View('plongee/plongee_show/plongee_show_palanquee/plongee_show_palanquee_removeform'))->generate([
            'palanquee' => $palanquee,
        ]);
    }

    private function updateEffectifPlongeur()
    {
        $nombrePlongeur=$this->plongeeManager->getEffectifPlongeur($_GET['plo_date'],$_GET['plo_mat_mid_soi']);
        $plongee=$this->plongeeManager->getOne([
            'PLO_DATE' => $_GET['plo_date'],
            'PLO_MAT_MID_SOI' => $_GET['plo_mat_mid_soi']
        ]);
        $plongee[0]->setPloEffectifBateau(intval($nombrePlongeur[0]['count(PLO_CONCERNER.PER_NUM)'])+2);
        $plongee[0]->setPloEffectifPlongeurs(intval($nombrePlongeur[0]['count(PLO_CONCERNER.PER_NUM)']));
        $plongee[0]->setPloEtat("Parametree");
        return $plongee;
        //$this->plongeeManager->update($plongee,false);
    }

    private function updateEffectifPalanquee()
    {
        $nombrePalanquee=$this->palanqueeManager->getPlongeurEffecif($_GET['plo_date'],$_GET['plo_mat_mid_soi']);
        $plongee=$this->plongeeManager->getOne([
            'PLO_DATE' => $_GET['plo_date'],
            'PLO_MAT_MID_SOI' => $_GET['plo_mat_mid_soi']
        ]);
        $plongee[0]->setPloNbPalanquees(intval($nombrePalanquee[0]['count(*)']));
        $plongee[0]->setPloEtat("Parametree");
        $this->plongeeManager->update($plongee,false);
    }

    private function verifierCompleter($base)
    {
        $complete=true;
        $palanqueeComplete =$this->palanqueeManager->getOne([
            'PLO_DATE'=> $_GET['plo_date'],
            'PLO_MAT_MID_SOI'=> $_GET['plo_mat_mid_soi']
        ]);
        foreach ($palanqueeComplete as $pal)
        {
            $palanquee=$this->palanqueeManager->getNombreConcerner($base,$pal->getPalNum());
            if(intval($palanquee[0]['count(*)'])<2 || intval($palanquee[0]['count(*)'])>5)
            {
                $complete = false;
            }
        }
        return $complete;
    }

    private function verifierPlongee() {
        if (!isset($_GET['plo_date']) || !isset($_GET['plo_mat_mid_soi']))
            header('location: /plongee');

        $plongee = $this->plongeeManager->getOne([
            'PLO_DATE' => $_GET['plo_date'],
            'PLO_MAT_MID_SOI' => $_GET['plo_mat_mid_soi']
        ]);

        if(is_null($plongee))
            header('location: /plongee');

        return $plongee;
    }

    public function validerPlongee()
    {
        if(isset($_POST['validerPlongee']))
        {
            if ($_POST['validerPlongee']=="plongeeValide")
            {
                $plongee = $this->plongeeManager->getOne([
                    'PLO_DATE' => $_GET['plo_date'],
                    'PLO_MAT_MID_SOI' => $_GET['plo_mat_mid_soi']
                ]);
                $plongee[0]->setPloEtat("Validee");
                $this->plongeeManager->update($plongee,false);
                header('location: /plongee/show/&plo_date='.$_GET['plo_date'].'&plo_mat_mid_soi='.$_GET['plo_mat_mid_soi']);
            }
        }
        (new View('plongee/plongee_show/plongee_show_generale/plongee_show_generale_valider'))->generate([]);
    }

    /*
     * Vérification si le Plongeur n'est pas déjà dans la base pour cette palanquée
     */
    private function verifierPlongeurPalanquee() {
        $concerner = [
            'PLO_DATE' => $_GET["plo_date"],
            'PLO_MAT_MID_SOI' => $_GET["plo_mat_mid_soi"],
            'PAL_NUM' => $_GET['pal_num'],
            'PER_NUM' => $_POST["plongeur"]
        ];
        return empty($this->palanqueeManager->getPlongeurConcerner($concerner));
    }

    function verifierDate($date)
    {
        $modele='#([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))#';
        if(preg_match($modele,$date))
        {
            $tab = explode('-',$date);
            return checkdate(intval($tab[1]),intval($tab[2]),intval($tab[0]));
        }
        else
        {
            return false;
        }
    }

}



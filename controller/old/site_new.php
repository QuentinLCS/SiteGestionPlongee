<?php

include_once('../view/site/site_addform.html');

if ( isset($_POST['submit']) ) {
    if ( !empty($_POST['nom']) && !empty($_POST['localisation']) ) {
        $nom = $_POST['nom'];
        $localisation = $_POST['localisation'];

        $req = "select * from PLO_SITE";
        $db->LireDonneesPDO2($req, $tab);
        $nbSites = count($tab);
        $idSite = $nbSites+1; //incremente le numero du site automatiquement

        $i=0;
        if ($nom != $tab[0]['SIT_NOM'] || $localisation != $tab[0]['SIT_LOCALISATION'] )
            while (($nom != $tab[$i]['SIT_NOM'] || $localisation != $tab[$i]['SIT_LOCALISATION']) && ++$i < $nbSites);
        else if($nom == $tab[0]['SIT_NOM'] && $localisation == $tab[0]['SIT_LOCALISATION'] )
            $i=0;
        else
            $i = $nbSites;
        //Marche mais pas beau -> peut mieux faire


        if($i==$nbSites) {
            $req2 = "INSERT INTO PLO_SITE(SIT_NUM,SIT_NOM,SIT_LOCALISATION) values (" . $idSite . ",'$nom','$localisation')";
            $cur = $db->preparerRequetePDO($req2);
            $db->majDonneesPrepareesPDO($cur);
            header("Location: ?page=site");
        }
        else{
            echo "Ce site existe déjà";
        }
    }


}
<?php

$sql = 'SELECT * FROM PLO_SITE WHERE SIT_NUM = '. $_GET['id'];
$db->LireDonneesPDO2($sql,$site);

$sql2= 'SELECT * FROM PLO_SITE';
$db->LireDonneesPDO2($sql2,$sites);
$nbSites=count($sites);

include_once ('../view/site/site_show/site_show_index.html');

if ( isset($_POST['submit']) ) {
    if ( !empty($_POST['nom']) && !empty($_POST['localisation']) ) {
        $siteID = $_GET['id'];
        $nom = $_POST['nom'];
        $localisation = $_POST['localisation'];

        $i=0;


        if ($nom != $site[0]['SIT_NOM'] || $localisation != $site[0]['SIT_LOCALISATION'])
            while (($nom != $sites[$i]['SIT_NOM'] || $localisation != $sites[$i]['SIT_LOCALISATION']) && ++$i < $nbSites);
        else
            $i = $nbSites;


        if($i==$nbSites) {
            $req = "UPDATE PLO_SITE SET SIT_NOM ='$nom', SIT_LOCALISATION = '$localisation' WHERE SIT_NUM =" . $siteID;
            $cur = $db->preparerRequetePDO($req);
            $db->majDonneesPrepareesPDO($cur);
            header("Location: ?page=site");
        }
        else{
            echo "Ce site est déjà enregistré";
        }
    }
}
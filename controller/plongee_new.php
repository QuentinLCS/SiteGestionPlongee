<?php

    $sql = "SELECT * FROM PLO_PERSONNE JOIN PLO_DIRECTEUR USING(PER_NUM)";
    $numDir = $db->LireDonneesPDO1($sql, $listDir);

    $sql = "SELECT * FROM PLO_PERSONNE JOIN PLO_SECURITE_DE_SURFACE USING(PER_NUM)";
    $numSecu = $db->LireDonneesPDO1($sql, $listSecu);

    $sql = "SELECT * FROM PLO_EMBARCATION";
    $numEmb = $db->LireDonneesPDO1($sql, $listEmb);

    $sql = "SELECT * FROM PLO_SITE";
    $numSite = $db->LireDonneesPDO1($sql, $listSite);

include("../view/plongee/plongee_addform.html");

if (!empty($_POST)) {

    $erreur = false;
    if (isset($_POST["date"])) {
        $date = $_POST["date"];
    } else {
        $erreur = true;
    }

    if (isset($_POST["periode"])) {
        $periode = ($_POST["periode"]);
    } else {
        $erreur = true;
    }

    if (isset($_POST["site"]) && $_POST["site"] != "") {
        $site = $_POST["site"];
    } else {
        $erreur = true;
    }

    if (isset($_POST["embarcation"])) {
        $embNum = intval($_POST["embarcation"],10) ;
    } else {
        $erreur = true;
    }

    if (isset($_POST["effectifP"]) && $_POST["effectifP"] != "") {
        $effectifP = intval($_POST["effectifP"], 10) ;
    } else {
        $erreur = true;
    }

    if (isset($_POST["effectifB"]) && $_POST["effectifB"] != "") {
        $effectifB = intval($_POST["effectifB"],10) ;
    } else {
        $erreur = true;
    }

    if (isset($_POST["directeur"])) {
        $directeurNum = intval($_POST["directeur"],10);
        /*
        $directeur = explode(" ",$_POST["directeur"],2);
        $directeurNom = $directeur[0];
        $directeurPrenom = $directeur[1];
        */
    } else {
        $erreur = true;
    }

    if (isset($_POST["securite"])) {
        $securiteNum = intval($_POST["securite"],10);
        /*
        $securite = explode(" ",$_POST["securite"],2);
        $securiteNom = $securite[0];
        $securitePrenom = $securite[1];
        */
    } else {
        $erreur = true;
    }

    if (!$erreur) {
        /*
        $sql  = "SELECT PER_NUM as num FROM PLO_PERSONNE WHERE PER_NOM = '$directeurNom' AND PER_PRENOM = '$directeurPrenom'";
        $db->LireDonneesPDO1($sql, $res);
        $directeurNum = intval($res[0]['num'],10) ;


        $sql  = "SELECT `PER_NUM` as num FROM `PLO_PERSONNE` WHERE `PER_NOM` = '".$securiteNom."' AND `PER_PRENOM` = '".$securitePrenom."'";
        $db->LireDonneesPDO1($sql, $res);
        $securiteNum = intval($res[0]['num'],10) ;
        */

        $sql  = "SELECT `SIT_NUM` as num FROM `PLO_SITE` WHERE `SIT_NOM` = '".$site."'";
        $db->LireDonneesPDO1($sql, $res);
        $siteNum = intval($res[0]['num'],10) ;

        /*
        $sql = "SELECT EMB_NUM as num FROM PLO_EMBARCATION WHERE EMB_NOM = '$embarcation'";
        $db->LireDonneesPDO1($sql, $res);
        $embNum =intval($res[0]['num'],10) ;
        */

        $sql = "INSERT INTO PLO_PLONGEE (PLO_DATE, PLO_MATIN_APRESMIDI, SIT_NUM, EMB_NUM, PER_NUM_DIR, PER_NUM_SECU, PLO_EFFECTIF_PLONGEURS, PLO_EFFECTIF_BATEAU, PLO_NB_PALANQUEES) VALUES ('".$date."','".$periode."',".$siteNum.",'".$embNum."',".$directeurNum.",".$securiteNum.",".$effectifP.",".$effectifB.",0)";
        $yes = $db->majDonneesPDO($sql);
        if ($yes == 1) {
            echo "<script>M.toast({html: 'Votre Plongée à bien été ajoutée'})</script>";
        } else {
            echo "<script>M.toast({html: 'Votre Plongée na pas pu être ajoutée'})</script>";
        }
    }

}

function verifierText($text) {
    if (isset($_POST["$text"]))
        echo $_POST["$text"];
}

function VerifierSelect ($pa, $n) {
    if (isset($_POST[$pa]))
    {
        if ($_POST[$pa] == $n) {
            echo "selected";
        }
    }
}

function remplirOptionNom($tab,$nbLignes)
{
    for ($i=0;$i<$nbLignes;$i++)
    {
        $tab[$i]["PER_NOM"] = utf8_encode($tab[$i]["PER_NOM"]);
        $tab[$i]["PER_PRENOM"] = utf8_encode($tab[$i]["PER_PRENOM"]);
        echo '<option value="'.$tab[$i]["PER_NUM"].'">'.$tab[$i]['PER_NOM'].' '.$tab[$i]['PER_PRENOM'];
        echo '</option>';
    }
}

function remplirOptionEmb($tab,$nbLignes)
{
    for ($i=0;$i<$nbLignes;$i++)
    {
        $tab[$i]["EMB_NOM"] = utf8_encode($tab[$i]["EMB_NOM"]);
        echo '<option value="'.$tab[$i]["EMB_NUM"].'">'.$tab[$i]['EMB_NOM'];
        echo '</option>';
    }
}

function remplirOptionSite($tab,$nbLignes)
{
    for ($i=0;$i<$nbLignes;$i++)
    {
        $tab[$i]["SIT_NOM"] = utf8_encode($tab[$i]["SIT_NOM"]);
        echo '<option value="'.$tab[$i]["SIT_NUM"].'">'.$tab[$i]['SIT_NOM'];
        echo '</option>';
    }
}
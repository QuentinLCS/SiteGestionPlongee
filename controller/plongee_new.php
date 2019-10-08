<?php

include("../view/plongee/plongee_addform.html");

if (!empty($_POST)) {

    /*
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    */

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
        $embarcation = $_POST["embarcation"];
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

    if (isset($_POST["directeur"]) && $_POST["directeur"] != "") {
        $directeur = explode(" ",$_POST["directeur"],2);
        $directeurNom = $directeur[0];
        $directeurPrenom = $directeur[1];
    } else {
        $erreur = true;
    }

    if (isset($_POST["securite"]) && $_POST["securite"] != "") {
        $securite = explode(" ",$_POST["securite"],2);
        $securiteNom = $securite[0];
        $securitePrenom = $securite[1];
    } else {
        $erreur = true;
    }

    if (!$erreur) {
        $sql  = "SELECT PER_NUM as num FROM PLO_PERSONNE WHERE PER_NOM = '$directeurNom' AND PER_PRENOM = '$directeurPrenom'";
        $db->LireDonneesPDO1($sql, $res);
        $directeurNum = intval($res[0]['num'],10) ;

        $sql  = "SELECT `PER_NUM` as num FROM `PLO_PERSONNE` WHERE `PER_NOM` = '".$securiteNom."' AND `PER_PRENOM` = '".$securitePrenom."'";
        $db->LireDonneesPDO1($sql, $res);
        $securiteNum = intval($res[0]['num'],10) ;

        $sql  = "SELECT `SIT_NUM` as num FROM `PLO_SITE` WHERE `SIT_NOM` = '".$site."'";
        $db->LireDonneesPDO1($sql, $res);
        $siteNum = intval($res[0]['num'],10) ;

        $sql = "SELECT EMB_NUM as num FROM PLO_EMBARCATION WHERE EMB_NOM = '$embarcation'";
        $db->LireDonneesPDO1($sql, $res);
        $embNum =intval($res[0]['num'],10) ;

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
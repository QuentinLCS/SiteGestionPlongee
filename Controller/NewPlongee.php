<?php

include("../View/Plongee/NewPlongeeForm.html");
include_once("../utils/utils_bdd.php");



// Insertion complete
//INSERT INTO `PLO_PLONGEE` (`PLO_DATE`, `PLO_MATIN_APRESMIDI`, `SIT_NUM`, `EMB_NUM`, `PER_NUM_DIR`, `PER_NUM_SECU`, `PLO_EFFECTIF_PLONGEURS`, `PLO_EFFECTIF_BATEAU`, `PLO_NB_PALANQUEES`)
// VALUES ('2019-10-09', 'm', '1', 'Beclem', '1', '1', '3', '3', '2')

//Num DIR
//SELECT `PER_NUM` FROM `PLO_PERSONNE` WHERE `PER_NOM` = 'Carré' AND `PER_PRENOM` = 'Quentin'
//$sql  = 'SELECT `PER_NUM` FROM `PLO_PERSONNE` WHERE `PER_NOM` = \'Carré\' AND `PER_PRENOM` = \'Quentin\'';


if (!empty($_POST)) {

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

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
        $effectifP = $_POST["effectifP"];
    } else {
        $erreur = true;
    }

    if (isset($_POST["effectifB"]) && $_POST["effectifB"] != "") {
        $effectifB = $_POST["effectifB"];
    } else {
        $erreur = true;
    }

    if (isset($_POST["directeur"]) && $_POST["directeur"] != "") {
        $directeur = explode(" ",$_POST["directeur"]);
        $directeurNom = $directeur[0];
        $directeurPrenom = $directeur[1];
    } else {
        $erreur = true;
    }

    if (isset($_POST["securite"]) && $_POST["securite"] != "") {
        $securite = $_POST["securite"];
    } else {
        $erreur = true;
    }

    if (!$erreur) {
        $sql  = "SELECT `PER_NUM` FROM `PLO_PERSONNE` WHERE `PER_NOM` = '".$directeurNom."' AND `PER_PRENOM` = '".$directeurPrenom."'";
        $db->LireDonneesPDO1($sql, $res);
        $directeurNum = $res[0];
        echo $directeurNum;
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
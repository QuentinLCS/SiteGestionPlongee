<?php

include_once('../view/palanquee/palanquee_addform.html');

if (!empty($_POST)) {

    //Si il manque des informations
    $erreur = false;
    print_r($_POST);

    //Récupère la date depuis l'url
    if (isset($_GET["date"])) {
        $date = $_GET["date"];
    } else {
        $erreur = true;
    }

    //Récupère la période depuis l'url
    if (isset($_GET["periode"])) {
        $periode = $_GET["periode"];
    } else {
        $erreur = true;
    }


    //Récupère l'heure de départ depuis le formulaire
    if (isset($_POST["heureD"])) {
        $heureD = $_POST["heureD"];
    } else {
        $heureD = null;
    }

    //Récupère l'heure de retour depuis le formulaire
    if (isset($_POST["heureA"])) {
        $heureA = $_POST["heureA"];
    } else {
        $heureA = null;
    }

    //Récupère le temps prévu de départ depuis le formulaire
    if (isset($_POST["tempsP"])) {
        $tempsP = $_POST["tempsP"];
    } else {
        $tempsP = null;
    }

    //Récupère le temps realisé de départ depuis le formulaire
    if (isset($_POST["tempsR"])) {
        $tempsR = $_POST["tempsR"];
    } else {
        $tempsR = null;
    }

    //Récupère la profondeur prévue sur le bateau depuis le formulaire
    if (isset($_POST["profondeurP"]) && $_POST["profondeurP"] != "") {
        $profondeurP = floatval($_POST["profondeurP"]) ;
    } else {
        $profondeurP = null;
    }

    //Récupère la profondeur prévue sur le bateau depuis le formulaire
    if (isset($_POST["profondeurR"]) && $_POST["profondeurR"] != "") {
        $profondeurR = floatval($_POST["profondeurR"]) ;
    } else {
        $profondeurR = null;
    }


    //Récupère le num du plongeur depuis le formulaire
    if (isset($_POST["plongeur"])) {
        $plongeur = intval($_POST["plongeur"],10);
    } else {
        $plongeur = null;
    }


    if (!$erreur) {

        //Récupère le nombre de palanquee pour une plongée
        $sql = "SELECT COUNT(*) as nb FROM PLO_PALANQUEE WHERE `PLO_DATE` = '".$date."' AND `PLO_MAT_MID_SOI` = '".$periode."'";
        $db->LireDonneesPDO1($sql, $Palanquee);
        $nbPalanquee = ($Palanquee[0]['nb'])+1;
        echo $nbPalanquee;

        //Ajoute une nouvelle Plongee dans la Base de Donnée
        $sql = "INSERT INTO PLO_PALANQUEE (PLO_DATE, PLO_MAT_MID_SOI, PAL_NUM, PAL_PROFONDEUR_MAX, PAL_DUREE_MAX, PAL_HEURE_IMMERSION, PAL_HEURE_SORTIE_EAU, PAL_PROFONDEUR_REELLE, PAL_DUREE_FOND)"
            ."VALUES ('".$date."', '".$periode."', '.$nbPalanquee.', '.$profondeurP.', '.$profondeurR.', '".$heureD."', '".$heureA."', '.$profondeurR.', '.$tempsR.')";
        $yes = $db->majDonneesPDO($sql);

        //Affiche une mtofication si l'ajout est réussi ou non
        if ($yes == 1) {
            echo "<script>M.toast({html: 'La Palanquée à bien été ajoutée'})</script>";
        } else {
            echo "<script>M.toast({html: 'La Palanquée na pas pu être ajoutée'})</script>";
        }
    }

}

//Vérifie si un élément texte a déjà été envoyé
function verifierText($text) {
    if (isset($_POST["$text"]))
        echo $_POST["$text"];
}

//Vérifie si un élément select a déjà été envoyé
function VerifierSelect ($pa, $n) {
    if (isset($_POST[$pa]))
    {
        if ($_POST[$pa] == $n) {
            echo "selected";
        }
    }
}

//Rempli un élement select avec les informations de la base de donnée sur les personnes
function remplirOptionNom($tab,$nbLignes)
{
    for ($i=0;$i<$nbLignes;$i++)
    {
        //On encode le texte reçu en UTF-8 pour les accents
        $tab[$i]["PER_NOM"] = utf8_encode($tab[$i]["PER_NOM"]);
        $tab[$i]["PER_PRENOM"] = utf8_encode($tab[$i]["PER_PRENOM"]);
        //On insère une ligne option  entre les balises select
        echo '<option value="'.$tab[$i]["PER_NUM"].'">'.$tab[$i]['PER_NOM'].' '.$tab[$i]['PER_PRENOM'];
        echo '</option>';
    }
}
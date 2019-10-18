<?php

    //Récupère tous les Directeurs et leur nombre
    $sql = "SELECT * FROM PLO_PERSONNE JOIN PLO_DIRECTEUR USING(PER_NUM)";
    $numDir = $db->LireDonneesPDO1($sql, $listDir);

    //Récupère tous les personne en Sécurité de Surface et leur nombre
    $sql = "SELECT * FROM PLO_PERSONNE JOIN PLO_SECURITE_DE_SURFACE USING(PER_NUM)";
    $numSecu = $db->LireDonneesPDO1($sql, $listSecu);

    //Récupère tous les embarcations et leur nombre
    $sql = "SELECT * FROM PLO_EMBARCATION";
    $numEmb = $db->LireDonneesPDO1($sql, $listEmb);

    //Récupère tous les sites et leur nombre
    $sql = "SELECT * FROM PLO_SITE";
    $numSite = $db->LireDonneesPDO1($sql, $listSite);

include("../view/plongee/plongee_addform.html");

if (!empty($_POST)) {

    //Si il manque des informations
    $erreur = false;

    //Récupère la date depuis le formulaire
    if (isset($_POST["date"])) {
        $date = $_POST["date"];
    } else {
        $erreur = true;
    }

    //Récupère le code de la periode depuis le formulaire
    if (isset($_POST["periode"])) {
        $periode = ($_POST["periode"]);
    } else {
        $erreur = true;
    }

    //Récupère le numéro du Site depuis le formulaire
    if (isset($_POST["site"]) && $_POST["site"] != "") {
        $siteNum = intval($_POST["site"],10) ;
    } else {
        $erreur = true;
    }

    //Récupère le numéro de l'embarcation depuis le formulaire
    if (isset($_POST["embarcation"])) {
        $embNum = intval($_POST["embarcation"],10) ;
    } else {
        $erreur = true;
    }

    //Récupère l'effactif de plongeur depuis le formulaire
    if (isset($_POST["effectifP"]) && $_POST["effectifP"] != "") {
        $effectifP = intval($_POST["effectifP"], 10) ;
    } else {
        $effectifP = null;
    }

    //Récupère l'effactif sur le bateau depuis le formulaire
    if (isset($_POST["effectifB"]) && $_POST["effectifB"] != "") {
        $effectifB = intval($_POST["effectifB"],10) ;
    } else {
        $effectifB = null;
    }

    //Récupère le num du directeur depuis le formulaire
    if (isset($_POST["directeur"])) {
        $directeurNum = intval($_POST["directeur"],10);
    } else {
        $erreur = true;
    }

    //Récupère le num de l'agent de sécurité depuis le formulaire
    if (isset($_POST["securite"])) {
        $securiteNum = intval($_POST["securite"],10);
    } else {
        $erreur = true;
    }

    if (isset($_POST["EN"])) {
        $envoyer = $_POST["EN"];
    } else {
        $erreur = true;
    }

    if (!$erreur) {

        //Ajoute une nouvelle Plongee dans la Base de Donnée
        $sql = "INSERT INTO PLO_PLONGEE (PLO_DATE, PloMatinApresmidi, SIT_NUM, EMB_NUM, PER_NUM_DIR, PER_NUM_SECU, PLO_EFFECTIF_PLONGEURS, PLO_EFFECTIF_BATEAU, PLO_NB_PALANQUEES)"
            ." VALUES ('".$date."','".$periode."',".$siteNum.",'".$embNum."',".$directeurNum.",".$securiteNum.",".$effectifP.",".$effectifB.",0)";
        $yes = $db->majDonneesPDO($sql);

        //Affiche une notification si l'ajout est réussi ou non
        if ($yes == 1) {
            echo "<script>M.toast({html: 'Votre Plongée à bien été ajoutée'})</script>";
        } else {
            echo "<script>M.toast({html: 'Votre Plongée na pas pu être ajoutée'})</script>";
        }

        if ($envoyer == "Nouvelle Palanquée") {
            echo "<script type='text/javascript'>document.location.replace('?page=palanquee_new&date=".$date."&periode=".$periode."');</script>";
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
function remplirOptionNom($tab,$nbLignes,$id)
{
    for ($i=0;$i<$nbLignes;$i++)
    {
        //On encode le texte reçu en UTF-8 pour les accents
        $tab[$i]["PER_NOM"] = utf8_encode($tab[$i]["PER_NOM"]);
        $tab[$i]["PER_PRENOM"] = utf8_encode($tab[$i]["PER_PRENOM"]);
        //On insère une ligne option  entre les balises select
        echo '<option value="'.$tab[$i]["PER_NUM"].'" ';
        VerifierSelect($id,$tab[$i]["PER_NUM"]);
        echo' >'.$tab[$i]['PER_NOM'].' '.$tab[$i]['PER_PRENOM'].'</option>';
    }
}

//Rempli un élement select avec les informations de la base de donnée sur les embarcation
function remplirOptionEmb($tab,$nbLignes, $id)
{
    for ($i=0;$i<$nbLignes;$i++)
    {
        $tab[$i]["EMB_NOM"] = utf8_encode($tab[$i]["EMB_NOM"]);
        echo '<option value="'.$tab[$i]["EMB_NUM"].'"';
        VerifierSelect($id,$tab[$i]["EMB_NUM"]);
        echo '>'.$tab[$i]['EMB_NOM'];
        echo '</option>';
    }
}

//Rempli un élement select avec les informations de la base de donnée sur les sites
function remplirOptionSite($tab,$nbLignes, $id)
{
    for ($i=0;$i<$nbLignes;$i++)
    {
        $tab[$i]["SIT_NOM"] = utf8_encode($tab[$i]["SIT_NOM"]);
        echo '<option value="'.$tab[$i]["SIT_NUM"].'"';
        VerifierSelect($id,$tab[$i]["SIT_NUM"]);
        echo '>'.$tab[$i]['SIT_NOM'];
        echo '</option>';
    }
}
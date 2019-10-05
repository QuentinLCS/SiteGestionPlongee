<?php

$sql = 'SELECT PER_NOM, PER_PRENOM, APT_CODE, APT_LIBELLE FROM PLO_PERSONNE JOIN PLO_PLONGEUR USING (PER_NUM) JOIN PLO_APTITUDE USING (APT_CODE) WHERE PER_NUM =' . $_GET['id'];
$db->LireDonneesPDO2($sql, $utilisateur);

$sql = 'SELECT * FROM PLO_APTITUDE';
$db->LireDonneesPDO2($sql, $aptitudes);

include_once('../view/form/form_modification_personne.php');

include_once('../model/Traitement.php');

if ( isset($_POST['submit']) ) {
    if ( !empty($_POST['nom']) && !empty($_POST['prenom']) ) {
        $nom = strtoupper(enleverCaracteresSpeciaux($_POST['nom']));
        $prenom = ucfirst(enleverCaracteresSpeciaux($_POST['prenom']));
        $aptitude = $_POST['aptitude'];

        $db->LireDonneesPDO2('SELECT * FROM PLO_PERSONNE', $personnes);

        $nbPersonnes = count($personnes);

        $i = 0;

        // Si le prénom ou le nom a été modifié
        if ($nom != $utilisateur[0]['PER_NOM'] || $prenom != $utilisateur[0]['PER_PRENOM'])
            while (($nom != $personnes[$i]['PER_NOM'] || $prenom != $personnes[$i]['PER_PRENOM']) && ++$i < $nbPersonnes);
        else
            $i = $nbPersonnes;


        if ($i == $nbPersonnes) {
            $id = $_GET['id'];
            $cur = $db->preparerRequetePDO("UPDATE PLO_PERSONNE SET PER_NOM = '$nom' , PER_PRENOM = '$prenom' WHERE PER_NUM = '$id'");
            $db->majDonneesPrepareesPDO($cur);
            $cur = $db->preparerRequetePDO("UPDATE PLO_PLONGEUR SET APT_CODE = '$aptitude' WHERE PER_NUM = '$id'");
            $db->majDonneesPrepareesPDO($cur);
            header("Location: ../public/?page=plongeur");
        } else
            echo "Personne déjà enregistrée.";
    }
}


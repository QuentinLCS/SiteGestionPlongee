<?php
    include('../view/formNewPlongeur.html');
    if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&&isset($_POST['competence']))
    {
        $tab2=[];
        $req3 = "select count(*) from PLO_PERSONNE";
        $db->LireDonneesPDO2($req3,$tab2);
        $nbColonnes=intval($tab2[0]['count(*)'],10);
        $req2 = "INSERT INTO PLO_PERSONNE(PER_NUM,PER_NOM,PER_PRENOM) VALUES (".$nbColonnes.",'".$_POST['nom']."','".$_POST['prenom']."')";
        var_dump($db->majDonneesPDO($req2));
    }
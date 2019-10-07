<?php
    include('../view/formNewPlongeur.html');
    if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&&isset($_POST['competence']))
    {
        $req6="select PER_NOM, PER_PRENOM from PLO_PERSONNE where PER_NOM like ('".$_POST['nom']."') and PER_PRENOM like ('".$_POST['prenom']."')";
        $db->LireDonneesPDO2($req6,$tab4);
        if($tab4[0]['PER_NOM']!=null || $tab4[0]['PER_PRENOM']!=null)
        {
            echo '<p>Utilisateur déjà existant !</p>';
        }
        else {
            $req3 = "select count(*) from PLO_PERSONNE";
            $req5 = "select APT_CODE from PLO_APTITUDE where APT_LIBELLE='" . $_POST['competence'] . "'";
            $db->LireDonneesPDO2($req3, $tab2);
            $db->LireDonneesPDO2($req5, $tab3);
            $nbColonnes = intval($tab2[0]['count(*)'], 10);
            $code = intval($tab3[0]['APT_CODE'], 10);
            $req2 = "INSERT INTO PLO_PERSONNE(PER_NUM,PER_NOM,PER_PRENOM) VALUES (" . $nbColonnes . ",'" . $_POST['nom'] . "','" . $_POST['prenom'] . "')";
            $req4 = "INSERT INTO PLO_PLONGEUR(PER_NUM, APT_CODE) VALUES (" . $nbColonnes . "," . $code . ")";
            $db->majDonneesPDO($req2);
            $db->majDonneesPDO($req4);
            //header('Location:home');
        }
    }
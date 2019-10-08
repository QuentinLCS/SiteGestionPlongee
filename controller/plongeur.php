<?php
    $req = "select PER_NUM,PER_NOM,PER_PRENOM,APT_LIBELLE from PLO_PLONGEUR join PLO_PERSONNE using(PER_NUM) join PLO_APTITUDE using(APT_CODE) order by PER_NUM";
    $db->LireDonneesPDO2($req, $tab);

    include_once('../view/plongeur/plongeur_index.html');

     ?>




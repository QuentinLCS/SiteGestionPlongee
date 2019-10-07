<?php

?>
<div>Liste des plongeurs</div>
<table>
    <thead>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Aptitude</th>
        <th>Gestion</th>
    </thead>
    <tbody>
    <?php
    $req = "select PER_NUM,PER_NOM,PER_PRENOM,APT_LIBELLE from PLO_PLONGEUR join PLO_PERSONNE using(PER_NUM) join PLO_APTITUDE using(APT_CODE) order by PER_NUM";
    $db->LireDonneesPDO2($req, $tab);

    foreach($tab as $key=>$value){
        echo "<tr>";
     foreach ($value as $val){



      echo  "<td>$val</td>";

     }
        echo '<td><a href="?page=modification_personne&id='.$value["PER_NUM"].'" class="waves-effect waves-light btn yellow accent-4 tooltipped" data-position="top" data-tooltip="Modifier le plongeur"><i class="material-icons white-text">remove_red_eye</i></a>';
        include('../view/form/suppression_personne.php');
        echo '</td></tr>';
    }  ?>
    </tbody>
</table>

<div class="fixed-action-btn">
    <a class="btn-floating btn-large blue modal-trigger" href="?page=formNewPlongeur">
        <i class="large material-icons">edit</i>
    </a>
</div>



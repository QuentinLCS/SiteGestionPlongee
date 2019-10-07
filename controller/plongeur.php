<?php

?>
<div>Liste des plongeurs</div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Aptitude</th>
            <th>Gestion</th>
        </tr>
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
     echo '<td><a href="?page=modification_personne&id='.$value["PER_NUM"].'" class="waves-effect waves-light btn yellow accent-4 tooltipped" data-position="top" data-tooltip="Modifier le plongeur"><i class="material-icons white-text">remove_red_eye</i></a></td></tr>';
     }  ?>
    </tbody>
</table>

<div class="fixed-action-btn">
    <a class="btn-floating btn-large blue modal-trigger pulse" href="/ProjetPlongee2A/public/?page=formNewPlongeur">
        <i class="large material-icons">edit</i>
    </a>
</div>



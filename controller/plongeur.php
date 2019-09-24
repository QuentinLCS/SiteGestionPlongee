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
    $req = "select * from PLO_PLONGEUR";
    $db->LireDonneesPDO2($req, $tab);
    AfficherDonnee2($tab);
    foreach($tab as $key=>$value){
        echo "<tr>";
     foreach ($value as $val){

    ?>

        <td><?php echo $val; ?></td>

    <?php }
     echo "</tr>";
    } ?>
    </tbody>
</table>



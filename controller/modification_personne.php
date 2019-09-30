<?php

$sql = 'SELECT * FROM PLO_PERSONNE WHERE PER_NUM = '. $_GET['id'];
$db->LireDonneesPDO2($sql, $resultat);

include('../view/form/form_modification_personne.php');
?>

    <script>
        <?php include('../public/assets/js/personne_entree.js'); ?>
    </script>


<?php

$sql = 'SELECT PER_NOM, PER_PRENOM, APT_CODE, APT_LIBELLE FROM PLO_PERSONNE JOIN PLO_PLONGEUR USING (PER_NUM) JOIN PLO_APTITUDE USING (APT_CODE) WHERE PER_NUM =' . $_GET['id'];
$db->LireDonneesPDO2($sql, $utilisateur);

$sql = 'SELECT * FROM PLO_APTITUDE';
$db->LireDonneesPDO2($sql, $aptitudes);

include_once('../view/form/form_modification_personne.php');




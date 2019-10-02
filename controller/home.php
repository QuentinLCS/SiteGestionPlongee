<?php
include_once('../view/home.html');

$req = 'SELECT * FROM plo_personne';
$db->LireDonneesPDO2($req, $tab);
echo '<pre>';
print_r($tab);

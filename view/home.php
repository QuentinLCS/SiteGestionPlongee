<?php
include_once('home.html');
phpinfo();
$req = "INSERT INTO bidon VALUES (99,'évier','blanc')";
$cur = $db->LireDonneesPDO2($req, $tab);
echo '<pre>';
print_r($tab);

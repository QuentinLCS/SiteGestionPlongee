<?php

$sql = 'SELECT count(*) as nb FROM plo_palanquee';
$db->LireDonneesPDO2($sql, $nbPalanquees);

$sql = 'SELECT count(*) as nb FROM plo_plongeur';
$db->LireDonneesPDO2($sql, $nbPlongeurs);

$sql = 'SELECT count(*) as nb FROM plo_site';
$db->LireDonneesPDO2($sql, $nbSites);

$sql = 'SELECT count(*) as nb FROM plo_plongee';
$db->LireDonneesPDO2($sql, $nbPlongees);

include_once('../view/home/home.html');
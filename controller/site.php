<?php

$sql = 'select * from PLO_SITE ORDER BY sit_nom';
$db->LireDonneesPDO2($sql, $allSites);

include_once('../view/site/site_index.html');
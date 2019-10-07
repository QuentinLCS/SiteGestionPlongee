<?php

$sql = 'select * from PLO_PALANQUEE ORDER BY plo_date';
$db->LireDonneesPDO2($sql, $allPalanquees);

include_once('../view/Palanquee/palanquee_index.html');
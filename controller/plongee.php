<?php

$sql = 'select * from PLO_PLONGEE ORDER BY plo_date';
$db->LireDonneesPDO2($sql, $allPlongees);

include_once('../view/Plongee/plongee_index.html');
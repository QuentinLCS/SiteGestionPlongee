<?php

$sql = 'select * from PLO_PLONGEE ORDER BY plo_date';
$db->LireDonneesPDO2($sql, $allPlongees);

include_once('../view/plongee/plongee_index.html');
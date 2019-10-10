<?php
$search = '';
if (isset($_GET['search']))
    $search = $_GET['search'];

echo $search;
echo '----';


$sql = "SELECT * FROM PLO_PLONGEE where plo_date like upper('".$search."%')";
$db->LireDonneesPDO2($sql, $allPlongees);

include_once('../view/plongee/plongee_index.html');
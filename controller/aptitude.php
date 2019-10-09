<?php

include_once('../model/global/global_requetes.php');

getAll($db, ['PLO_APTITUDE' => []], $allAptitudes);

include_once('../view/aptitude/aptitude_index.html');

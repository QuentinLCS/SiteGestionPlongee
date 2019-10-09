<?php
include_once('../model/global/global_requetes.php');

countAll($db, ['plo_personne' => []], $nbPersonnes);
countAll($db, ['plo_plongeur' => []], $nbPlongeurs);
countAll($db, ['plo_site' => []], $nbSites);
countAll($db, ['plo_plongee' => []], $nbPlongees);

include_once('../view/home/home.html');
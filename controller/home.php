<?php
include_once('../model/global/global_requetes.php');

countAll($db, 'plo_personne', $nbPersonnes);
countAll($db, 'plo_personne', $nbPlongeurs);
countAll($db, 'plo_personne', $nbSites);
countAll($db, 'plo_personne', $nbPlongees);

include_once('../view/home/home.html');
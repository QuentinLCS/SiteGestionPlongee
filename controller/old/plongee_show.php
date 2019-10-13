<?php
include_once('../model/global/global_requetes.php');

getOne($db, [
    'PLO_PLONGEE' => [],
    'PLO_SITE' => [
        ['SIT_NUM']
    ],
    'PLO_EMBARCATION' => [
        ['EMB_NUM']
    ],
    'PLO_DIRECTEUR' => [
        ['PER_NUM_DIR', 'PER_NUM']
    ],
    'PLO_SECURITE_DE_SURFACE' => [
        ['PER_NUM_SECU','PER_NUM']
    ],
    'PLO_PERSONNE' => [
        ['PLO_SECURITE_DE_SURFACE' => 'PER_NUM', 'PER_NUM']
    ]],
    [
        'PLO_DATE' => $_GET['date'],
        'PLO_MAT_MID_SOI' => $_GET['periode']
    ],
    $plongee);

include_once('../view/plongee/plongee_show/plongee_show_index.html');
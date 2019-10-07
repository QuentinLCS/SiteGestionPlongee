<?php

/**
 * @param $db DataBase object.
 * @param $nomTable string représentant le nom de la table.
 * @param $sortie array de sortie de résultats de la requête.
 */
function countAll($db, $nomTable, &$sortie)
{
    $sql = 'SELECT count(*) as nb FROM '.$nomTable ;
    $db->LireDonneesPDO2($sql, $sortie);
}
<?php


/**
 * @param $db DataBase object.
 * @param $nomTable string représentant le nom de la table.
 * @param $sortie array de sortie de résultats de la requête.
 */
function countAll($db, $nomTable, &$sortie)
{
    $sql = 'SELECT count(*) as nb FROM ';
    
    $sql = jointure($sql, $nomTable);

    $db->LireDonneesPDO2($sql, $sortie);
}

function getAll($db, $nomTable, &$sortie) {
    $sql = 'SELECT * FROM ';

    $sql = jointure($sql, $nomTable);

    $db->LireDonneesPDO2($sql, $sortie);
}

function getOne($db, $nomTable, $id,&$sortie) {
    $sql = 'SELECT * FROM ';
    $i = count($id);

    $sql = jointure($sql, $nomTable);

    $sql .= ' WHERE';

    foreach ($id as $key=>$value)
        $sql .= " $key = '$value'". (--$i > 0 ? ' AND' : ';');

    $db->LireDonneesPDO2($sql, $sortie);
}

function jointure($sql, $nomTable) {
    $first = true;

    foreach ($nomTable as $key=>$value) {
        $j = count($value);

        if ($first)
            $sql .= $key.' ini';

        else {
            $sql .= " JOIN ";

            foreach ($value as $val) {

                $sql .= "$key ON ";

                if (is_string(key($val))) {
                    $sql .= key($val) . '.' . $val[key($val)] . ' = ';
                    $sql .= $key.'.'.$val[key($val)];
                } else {
                    $sql .= "ini.$val[0]" . " = ";
                    $sql .= $key.'.'.(count($val) == 1 ? $val[0] : $val[1]);
                }
                next($val);



                $sql .= (--$j > 0 ? ' AND' : '');
            }
        }

        $first = false;
    }
    return $sql;
}
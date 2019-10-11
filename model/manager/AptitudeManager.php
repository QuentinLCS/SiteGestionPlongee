<?php

require_once('_Model.php');

class AptitudeManager extends _Model
{
    private static $entity = "APTITUDE";
    private static $table = 'PLO_APTITUDE';

    public function __construct()
    {

    }

    public function getAptitudes(&$sortie)
    {
        parent::getAll(self::$table, self::$entity, $sortie);
    }

    public function countAptitudes(&$sortie)
    {
        parent::countAll(self::$table, self::$entity,$sortie);
    }
}
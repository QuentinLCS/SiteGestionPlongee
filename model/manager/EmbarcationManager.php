<?php

require_once('_Model.php');

class EmbarcationManager extends _Model
{
    public static $entity = 'EMBARCATION';
    public static $table = 'PLO_EMBARCATION';

    public function __construct()
    {
        // Actions à la création de l'entité.
    }

    public function getAll()
    {
        return parent::_getAll(self::$table, self::$entity);
    }

    public function countAll()
    {
        return parent::_countAll(self::$table);
    }

    public function getOne(array $id)
    {
        return parent::_getOne(self::$table, $id, self::$entity);
    }

    public function update($object)
    {
        // TODO: Implement update() method.
    }
}
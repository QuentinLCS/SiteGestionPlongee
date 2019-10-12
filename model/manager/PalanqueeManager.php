<?php

require_once('_Model.php');

class PalanqueeManager extends _Model
{
    public static $entity = 'PALANQUEE';
    public static $table = 'PLO_PALANQUEE';

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
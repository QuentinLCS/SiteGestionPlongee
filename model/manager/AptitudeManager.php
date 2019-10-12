<?php


class AptitudeManager extends _Model
{
    private $table;

    public function __construct()
    {
        $this->table = 'PLO_APTITUDE';
    }

    public function getAptitudes(&$sortie)
    {
        parent::getAll($this->table, $sortie);
    }

    public function countAptitudes(&$sortie)
    {
        parent::countAll('PLO_APTITUDE', $sortie);
    }
}
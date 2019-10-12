<?php

require_once('_Entity.php');

class Site extends _Entity
{
    private $sit_num;

    private $sit_nom;

    private $sit_localisation;

    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    /**
     * @return mixed
     */
    public function getSitNum()
    {
        return $this->sit_num;
    }

    /**
     * @param mixed $sit_num
     */
    public function setSitNum($sit_num)
    {
        $this->sit_num = $sit_num;
    }

    /**
     * @return mixed
     */
    public function getSitNom()
    {
        return $this->sit_nom;
    }

    /**
     * @param mixed $sit_nom
     */
    public function setSitNom($sit_nom)
    {
        $this->sit_nom = $sit_nom;
    }

    /**
     * @return mixed
     */
    public function getSitLocalisation()
    {
        return $this->sit_localisation;
    }

    /**
     * @param mixed $sit_localisation
     */
    public function setSitLocalisation($sit_localisation)
    {
        $this->sit_localisation = $sit_localisation;
    }



}
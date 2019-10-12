<?php

require_once('_Entity.php');

class Aptitude extends _Entity
{
    private $apt_code;

    private $apt_libelle;

    /**
     * Aptitude constructor.
     * Check if the setter exists.
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data);
    }



    // SETTERS

    /**
     * @param mixed $apt_code
     */
    public function setAptCode($apt_code)
    {
        $apt_code = (int) $apt_code;

        if ($apt_code > 0)
            $this->apt_code = $apt_code;

    }

    /**
     * @param mixed $apt_libelle
     */
    public function setAptLibelle($apt_libelle)
    {
        if (is_string($apt_libelle))
            $this->apt_libelle = $apt_libelle;
    }



    // GETTERS

    /**
     * @return mixed
     */
    public function getAptCode()
    {
        return $this->apt_code;
    }

    /**
     * @return mixed
     */
    public function getAptLibelle()
    {
        return $this->apt_libelle;
    }

}
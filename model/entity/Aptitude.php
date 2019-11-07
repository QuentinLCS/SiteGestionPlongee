<?php

require_once('_Entity.php');

class Aptitude extends _Entity
{
    private $old_apt_code;

    private $apt_code;

    private $apt_libelle;

    private $apt_num;

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
        if (is_string($apt_code))
            $this->apt_code = $apt_code;

        if (!isset($this->old_apt_code))
            $this->old_apt_code = $apt_code;

    }

    /**
     * @param mixed $apt_num
     */
    public function setAptNum($apt_num)
    {
            $this->apt_num = $apt_num;

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

    public function getAptNum()
    {
        return $this->apt_num;
    }


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
    public function getOldAptCode()
    {
        return $this->old_apt_code;
    }

    /**
     * @return mixed
     */
    public function getAptLibelle()
    {
        return $this->apt_libelle;
    }

}
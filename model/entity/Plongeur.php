<?php

require_once('_Entity.php');

class Plongeur extends _Entity
{
    private $per_num;

    private $apt_code;

    private $personne;

    private $aptitude;


    public function __construct(array $data, $add = false)
    {
        parent::__construct($data);

        $personneManager = new PersonneManager();
        $aptitudeManager = new AptitudeManager();
        $plongeurManager = new PlongeurManager();

        $this->personne = $personneManager->getOne(['PER_NUM' => $this->per_num]);
        $this->aptitude = $aptitudeManager->getOne(['APT_CODE' => $this->apt_code]);
    }

    /**
     * @return mixed
     */
    public function getPerNum()
    {
        return $this->per_num;
    }

    /**
     * @param mixed $per_num
     */
    public function setPerNum($per_num)
    {
        $this->per_num = $per_num;
    }

    /**
     * @return mixed
     */
    public function getAptCode()
    {
        return $this->apt_code;
    }

    /**
     * @param mixed $apt_code
     */
    public function setAptCode($apt_code)
    {
        $this->apt_code = $apt_code;
    }


    /**
     * @param mixed $aptitude
     */
    public function setAptitude($aptitude)
    {
        $this->aptitude = $aptitude;
    }

    public function getAptitude() {
        return $this->aptitude;
    }

    /**
     * @param mixed $personne
     */
    public function setPersonne($personne)
    {
        $this->personne = $personne;
    }

    public function getPersonne() {
        return $this->personne;
    }


}
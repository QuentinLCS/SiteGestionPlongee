<?php

require_once('_Entity.php');


class Personne extends _Entity
{
    private $per_num;

    private $per_nom;

    private $per_prenom;

    private $per_active;

    private $per_date_certif_med;


    public function __construct(array $data)
    {
        parent::__construct($data);
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
    public function getPerNom()
    {
        return $this->per_nom;
    }

    /**
     * @param mixed $per_nom
     */
    public function setPerNom($per_nom)
    {
        $this->per_nom = $per_nom;
    }

    /**
     * @return mixed
     */
    public function getPerPrenom()
    {
        return $this->per_prenom;
    }

    /**
     * @param mixed $per_prenom
     */
    public function setPerPrenom($per_prenom)
    {
        $this->per_prenom = $per_prenom;
    }

    /**
     * @return mixed
     */
    public function getPerActive()
    {
        return $this->per_active;
    }

    /**
     * @param mixed $per_active
     */
    public function setPerActive($per_active)
    {
        $this->per_active = $per_active;
    }

    /**
     * @return mixed
     */
    public function getPerDateCertifMed()
    {
        return $this->per_date_certif_med;
    }

    /**
     * @param $per_date_certif_med
     */
    public function setPerDateCertifMed($per_date_certif_med)
    {
        $date = DateTime::createFromFormat('d-m-Y', $per_date_certif_med);
        if ($date)
            $this->per_date_certif_med = $per_date_certif_med;
    }

}
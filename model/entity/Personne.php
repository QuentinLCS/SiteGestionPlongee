<?php


class Personne
{
    private $per_num;

    private $per_nom;

    private $per_prenom;

    private $per_active;

    private $per_date_certify_med;

    /**
     * @return mixed
     */
    public function getPerNum()
    {
        return $this->per_num;
    }

    /**
     * @param mixed $per_num
     * @return Personne
     */
    public function setPerNum($per_num)
    {
        $this->per_num = $per_num;
        return $this;
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
     * @return Personne
     */
    public function setPerNom($per_nom)
    {
        $this->per_nom = $per_nom;
        return $this;
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
     * @return Personne
     */
    public function setPerPrenom($per_prenom)
    {
        $this->per_prenom = $per_prenom;
        return $this;
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
     * @return Personne
     */
    public function setPerActive($per_active)
    {
        $this->per_active = $per_active;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPerDateCertifyMed()
    {
        return $this->per_date_certify_med;
    }

    /**
     * @param mixed $per_date_certify_med
     * @return Personne
     */
    public function setPerDateCertifyMed($per_date_certify_med)
    {
        $this->per_date_certify_med = $per_date_certify_med;
        return $this;
    }


}
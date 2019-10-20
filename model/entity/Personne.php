<?php

require_once('_Entity.php');


class Personne extends _Entity
{
    private $per_num;

    private $per_nom;

    private $per_prenom;

    private $per_active;

    private $per_date_certify_med;


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
    public function getPerDateCertifyMed()
    {
        return $this->per_date_certify_med;
    }

    /**
     * @param mixed $per_date_certify_med
     */
    public function setPerDateCertifyMed($per_date_certify_med)
    {
        $this->per_date_certify_med = $per_date_certify_med;
    }

    private function enleverCaracteresSpeciaux($text)
    {
        $utf8 = array(
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u' => 'A',
            '/[ÍÌÎÏ]/u' => 'I',
            '/[íìîï]/u' => 'i',
            '/[éèêë]/u' => 'e',
            '/[ÉÈÊË]/u' => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u' => 'O',
            '/[úùûü]/u' => 'u',
            '/[ÚÙÛÜ]/u' => 'U',
            '/ç/' => 'c',
            '/Ç/' => 'C',
            '/ñ/' => 'n',
            '/Ñ/' => 'N',
            '/\[\]/u' => ' ', // guillemet simple
            '/[«»]/u' => ' ', // guillemet double
            '/ /' => ' ', // espace insécable (équiv. à 0x160)
            '/œ/' => 'oe',
            '/æ/' => 'ae',
            '/Œ/' => 'OE',
            '/Æ/' => 'AE',
        );

        return preg_replace(array_keys($utf8), array_values($utf8), $text);
    }


}
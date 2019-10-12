<?php


class Site
{
    private $sit_num;

    private $sit_nom;

    private $sit_localisation;

    /**
     * @return mixed
     */
    public function getSitNum()
    {
        return $this->sit_num;
    }

    /**
     * @param mixed $sit_num
     * @return Site
     */
    public function setSitNum($sit_num)
    {
        $this->sit_num = $sit_num;
        return $this;
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
     * @return Site
     */
    public function setSitNom($sit_nom)
    {
        $this->sit_nom = $sit_nom;
        return $this;
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
     * @return Site
     */
    public function setSitLocalisation($sit_localisation)
    {
        $this->sit_localisation = $sit_localisation;
        return $this;
    }


}
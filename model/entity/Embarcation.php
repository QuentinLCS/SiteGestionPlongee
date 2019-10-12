<?php


class Embarcation
{
    private $emb_num;

    private $emb_nom;

    /**
     * @return mixed
     */
    public function getEmbNum()
    {
        return $this->emb_num;
    }

    /**
     * @param mixed $emb_nom
     * @return Embarcation
     */
    public function setEmbNom($emb_nom)
    {
        $this->emb_nom = $emb_nom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmbNom()
    {
        return $this->emb_nom;
    }


}
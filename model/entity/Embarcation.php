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
     * @param mixed $emb_num
     */
    public function setEmbNum($emb_num)
    {
        $this->emb_num = $emb_num;
    }

    /**
     * @return mixed
     */
    public function getEmbNom()
    {
        return $this->emb_nom;
    }

    /**
     * @param mixed $emb_nom
     */
    public function setEmbNom($emb_nom)
    {
        $this->emb_nom = $emb_nom;
    }




}
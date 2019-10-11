<?php


class Plongee
{
    private $plo_date;

    private $plo_matin_apresmidi;

    private $site_num;

    private $emb_num;

    private $per_num_dir;

    private $per_num_secu;

    private $plo_effectif_plongeurs;

    private $plo_effectif_bateau;

    private $plo_nb_palanquees;

    private $plo_etat;

    /**
     * @return mixed
     */
    public function getPloDate()
    {
        return $this->plo_date;
    }

    /**
     * @param mixed $plo_date
     */
    public function setPloDate($plo_date)
    {
        $this->plo_date = $plo_date;
    }

    /**
     * @return mixed
     */
    public function getPloMatinApresmidi()
    {
        return $this->plo_matin_apresmidi;
    }

    /**
     * @param mixed $plo_matin_apresmidi
     */
    public function setPloMatinApresmidi($plo_matin_apresmidi)
    {
        $this->plo_matin_apresmidi = $plo_matin_apresmidi;
    }

    /**
     * @return mixed
     */
    public function getSiteNum()
    {
        return $this->site_num;
    }

    /**
     * @param mixed $site_num
     */
    public function setSiteNum($site_num)
    {
        $this->site_num = $site_num;
    }

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
    public function getPerNumDir()
    {
        return $this->per_num_dir;
    }

    /**
     * @param mixed $per_num_dir
     */
    public function setPerNumDir($per_num_dir)
    {
        $this->per_num_dir = $per_num_dir;
    }

    /**
     * @return mixed
     */
    public function getPerNumSecu()
    {
        return $this->per_num_secu;
    }

    /**
     * @param mixed $per_num_secu
     */
    public function setPerNumSecu($per_num_secu)
    {
        $this->per_num_secu = $per_num_secu;
    }

    /**
     * @return mixed
     */
    public function getPloEffectifPlongeurs()
    {
        return $this->plo_effectif_plongeurs;
    }

    /**
     * @param mixed $plo_effectif_plongeurs
     */
    public function setPloEffectifPlongeurs($plo_effectif_plongeurs)
    {
        $this->plo_effectif_plongeurs = $plo_effectif_plongeurs;
    }

    /**
     * @return mixed
     */
    public function getPloEffectifBateau()
    {
        return $this->plo_effectif_bateau;
    }

    /**
     * @param mixed $plo_effectif_bateau
     */
    public function setPloEffectifBateau($plo_effectif_bateau)
    {
        $this->plo_effectif_bateau = $plo_effectif_bateau;
    }

    /**
     * @return mixed
     */
    public function getPloNbPalanquees()
    {
        return $this->plo_nb_palanquees;
    }

    /**
     * @param mixed $plo_nb_palanquees
     */
    public function setPloNbPalanquees($plo_nb_palanquees)
    {
        $this->plo_nb_palanquees = $plo_nb_palanquees;
    }

    /**
     * @return mixed
     */
    public function getPloEtat()
    {
        return $this->plo_etat;
    }

    /**
     * @param mixed $plo_etat
     */
    public function setPloEtat($plo_etat)
    {
        $this->plo_etat = $plo_etat;
    }




}
<?php


class Palanquee
{
    private $plo_date;

    private $plo_matin_apresmidi;

    private $pal_num;

    private $pal_profondeur_max;

    private $pal_duree_max;

    private $pal_heure_immersion;

    private $pal_heure_sortie_eau;

    private $pal_profondeur_reelle;

    private $pal_duree_fond;

    /**
     * @return mixed
     */
    public function getPloDate()
    {
        return $this->plo_date;
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
     * @return Palanquee
     */
    public function setPloMatinApresmidi($plo_matin_apresmidi)
    {
        $this->plo_matin_apresmidi = $plo_matin_apresmidi;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPalNum()
    {
        return $this->pal_num;
    }

    /**
     * @param mixed $pal_num
     * @return Palanquee
     */
    public function setPalNum($pal_num)
    {
        $this->pal_num = $pal_num;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPalProfondeurMax()
    {
        return $this->pal_profondeur_max;
    }

    /**
     * @param mixed $pal_profondeur_max
     * @return Palanquee
     */
    public function setPalProfondeurMax($pal_profondeur_max)
    {
        $this->pal_profondeur_max = $pal_profondeur_max;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPalDureeMax()
    {
        return $this->pal_duree_max;
    }

    /**
     * @param mixed $pal_duree_max
     * @return Palanquee
     */
    public function setPalDureeMax($pal_duree_max)
    {
        $this->pal_duree_max = $pal_duree_max;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPalHeureImmersion()
    {
        return $this->pal_heure_immersion;
    }

    /**
     * @param mixed $pal_heure_immersion
     * @return Palanquee
     */
    public function setPalHeureImmersion($pal_heure_immersion)
    {
        $this->pal_heure_immersion = $pal_heure_immersion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPalHeureSortieEau()
    {
        return $this->pal_heure_sortie_eau;
    }

    /**
     * @param mixed $pal_heure_sortie_eau
     * @return Palanquee
     */
    public function setPalHeureSortieEau($pal_heure_sortie_eau)
    {
        $this->pal_heure_sortie_eau = $pal_heure_sortie_eau;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPalProfondeurReelle()
    {
        return $this->pal_profondeur_reelle;
    }

    /**
     * @param mixed $pal_profondeur_reelle
     * @return Palanquee
     */
    public function setPalProfondeurReelle($pal_profondeur_reelle)
    {
        $this->pal_profondeur_reelle = $pal_profondeur_reelle;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPalDureeFond()
    {
        return $this->pal_duree_fond;
    }

    /**
     * @param mixed $pal_duree_fond
     * @return Palanquee
     */
    public function setPalDureeFond($pal_duree_fond)
    {
        $this->pal_duree_fond = $pal_duree_fond;
        return $this;
    }


}
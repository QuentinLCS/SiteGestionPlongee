<?php

require_once('_Entity.php');

class Palanquee extends _Entity
{
    private $plo_date;

    private $plo_mat_mid_soi;

    private $pal_num;

    private $pal_profondeur_max;

    private $pal_duree_max;

    private $pal_heure_immersion;

    private $pal_heure_sortie_eau;

    private $pal_profondeur_reelle;

    private $pal_duree_fond;

    private $nbPlongeurs;
    private $palanqueeManager;

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->palanqueeManager = new PalanqueeManager();
    }

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
    public function getPloMatMidSoi()
    {
        return $this->plo_mat_mid_soi;
    }

    /**
     * @param $plo_mat_mid_soi
     */
    public function setPloMatMidSoi($plo_mat_mid_soi)
    {
        $this->plo_mat_mid_soi = $plo_mat_mid_soi;
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
     */
    public function setPalNum($pal_num)
    {
        $this->pal_num = $pal_num;
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
     */
    public function setPalProfondeurMax($pal_profondeur_max)
    {
        $this->pal_profondeur_max = $pal_profondeur_max;
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
     */
    public function setPalDureeMax($pal_duree_max)
    {
        $this->pal_duree_max = $pal_duree_max;
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
     */
    public function setPalHeureImmersion($pal_heure_immersion)
    {
        $this->pal_heure_immersion = $pal_heure_immersion;
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
     */
    public function setPalHeureSortieEau($pal_heure_sortie_eau)
    {
        $this->pal_heure_sortie_eau = $pal_heure_sortie_eau;
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
     */
    public function setPalProfondeurReelle($pal_profondeur_reelle)
    {
        $this->pal_profondeur_reelle = $pal_profondeur_reelle;
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
     */
    public function setPalDureeFond($pal_duree_fond)
    {
        $this->pal_duree_fond = $pal_duree_fond;
    }

    public function getNbPlongeurs() {
        $plongee[] = new Plongee([
            'PLO_DATE' => $this->plo_date,
            'PLO_MAT_MID_SOI' => $this->plo_mat_mid_soi
        ]);
        $nombre = $this->palanqueeManager->getNombreConcerner($plongee , $this->pal_num);
        return $nombre[0]['count(*)'];
    }


}
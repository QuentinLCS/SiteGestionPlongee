<?php

require_once('_Entity.php');

class Plongee extends _Entity
{
    private $plo_date;

    private $plo_mat_mid_soi;

    private $sit_num;

    private $emb_num;

    private $per_num_dir;

    private $per_num_secu;

    private $plo_effectif_plongeurs;

    private $plo_effectif_bateau;

    private $plo_nb_palanquees;

    private $plo_etat;

    private $site;

    private $siteManager;

    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->siteManager = new SiteManager();

        $this->site = $this->siteManager->getOne(['SIT_NUM' => $this->sit_num]);
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
    public function getSitNum()
    {
        return $this->sit_num;
    }

    /**
     * @param $sit_num
     */
    public function setSitNum($sit_num)
    {
        $this->sit_num = $sit_num;
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

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

}
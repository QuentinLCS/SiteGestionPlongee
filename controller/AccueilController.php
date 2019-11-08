<?php

require_once('view/View.php');
require_once('_ControllerClass.php');
require_once('model/utils/DateFomater.php');

/**
 * Class AccueilController
 */
class AccueilController extends _ControllerClass
{
    /**
     * @var AptitudeManager
     */
    private $personneManager;

    /**
     * @var PlongeurManager
     */
    private $plongeurManager;

    /**
     * @var PlongeeManager
     */
    private $plongeeManager;

    /**
     * @var siteManager
     */
    private $siteManager;


    private $aptitudeManager;


    /**
     * AccueilController constructor.
     * @param $url
     * @throws Exception
     */
    public function __construct($url)
    {
        $this->personneManager = new PersonneManager();
        $this->plongeurManager = new PlongeurManager();
        $this->plongeeManager = new PlongeeManager();
        $this->siteManager = new SiteManager();
        $this->aptitudeManager = new AptitudeManager();

        parent::__construct($url);
    }

    /**
     * Fonction chargée au chargement de la page.
     * @throws Exception
     */
    public function index()
    {
        var_dump($this->personneManager->getCertificatDepasse());

        $plongeesFutures = $this->plongeeManager->getPlongeesFutures();

        (new View('home/home'))->generate([
            'nbCertificatsInvalides' => $this->personneManager->getCertificatDepasse()[0],
            'nbActifs' => $this->personneManager->countActifs(),
            'nbPlongeurs' => $this->plongeurManager->countAll(),
            'nbPlongees' => $this->plongeeManager->countAll(),
            'nbSites' => $this->siteManager->countAll(),
            'nbAptitudes' => $this->aptitudeManager->countAll(),
            'allPlongeesFutures' => $plongeesFutures
            ]);
    }
}
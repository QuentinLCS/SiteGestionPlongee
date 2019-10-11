<?php

require_once('view/View.php');
require_once('_ControllerClass.php');

/**
 * Class AccueilController
 */
class AccueilController extends _ControllerClass
{
    /**
     * Manager des aptitudes afin de récupérer les info.s dans la BDD.
     * @var AptitudeManager
     */
    private $aptitudeManager;

    /**
     * Chemin vers la vue.
     * @var string
     */
    private $view;


    /**
     * AccueilController constructor.
     * @param $url
     * @throws Exception
     */
    public function __construct($url)
    {
        parent::__construct($url);
    }

    /**
     * Fonction chargée au chargement de la page.
     * @throws Exception
     */
    public function index()
    {
        $this->aptitudeManager = new AptitudeManager();
        $this->aptitudeManager->getAptitudes($aptitudes);

        $this->view = new View('home/home');
        $this->view->generate(['articles' => $aptitudes]);
    }
}
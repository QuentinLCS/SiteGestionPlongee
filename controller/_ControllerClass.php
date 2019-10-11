<?php


/**
 * Class _Controller
 */
abstract class _ControllerClass
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
     * _Controller constructor.
     * @param $url
     * @throws Exception
     */
    public function __construct($url)
    {
        if (isset($url) && count($url) > 1)
            throw new Exception('Page introuvable');
        else
            $this->index();
    }
}
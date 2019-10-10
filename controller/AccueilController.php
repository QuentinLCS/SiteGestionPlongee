<?php


class AccueilController
{
    private $aptitudeManager;
    private $view;

    public function __construct($url)
    {
        if (isset($url) && count($url) > 1)
            throw new Exception('Page introuvable');
        else
            $this->aptitudes();
    }

    public function aptitudes()
    {
        $this->aptitudeManager = new AptitudeManager();
        $this->aptitudeManager->getAptitudes($aptitudes);

        require_once('view/home/home.html');
    }
}
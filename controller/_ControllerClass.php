<?php


/**
 * Class _Controller
 */
abstract class _ControllerClass
{


    /**
     * _Controller constructor.
     * @param $url
     * @throws Exception
     */
    protected function __construct($url)
    {
        $urlSize = count($url);
        if (isset($url) && $urlSize > 5)
            throw new Exception('Page introuvable');
        else if ($urlSize == 1)
            $this->index();

        return $urlSize;
    }

    public abstract function index();
}
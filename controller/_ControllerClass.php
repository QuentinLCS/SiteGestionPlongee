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
    public function __construct($url)
    {
        if (isset($url) && count($url) > 1)
            throw new Exception('Page introuvable');
        else
            $this->index();
    }
}
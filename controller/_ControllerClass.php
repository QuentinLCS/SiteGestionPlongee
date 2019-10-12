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
        $urlSize = count($url);
        if (isset($url) && $urlSize > 3)
            throw new Exception('Page introuvable');
        else if ($urlSize == 1)
            $this->index();

        return $urlSize;
    }
}
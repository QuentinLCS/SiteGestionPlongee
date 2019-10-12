<?php

require_once('view/View.php');

class _Router
{
    private $_controller;
    private $_view;

    /**
     * @return mixed
     * @throws Exception
     */
    public function routeRequest()
    {
        try
        {

            spl_autoload_register(function($class){
                if (strpos($class, 'Manager') !== false)
                    $path = 'model/manager/';
                else
                    $path = 'model/entity/';

                require_once($path.$class.'.php');
            });

            $url = '';

            // INCLUSION DU CONTROLLER EN FONCTION DE L'URL
            if (isset($_GET['url']))
            {
                $url = explode('/', filter_var($_GET['url'],
                FILTER_SANITIZE_URL));

                $controller = ucfirst(strtolower($url[0]));
                $controllerClass = $controller.'Controller';
                $controllerFile = 'controller/'.$controllerClass.'.php';

                if (file_exists($controllerFile))
                {
                    require_once($controllerFile);
                    $this->_controller = new $controllerClass($url);
                }
                else
                    throw new Exception('Page introuvable');
            }
            else
                {
                require_once('controller/AccueilController.php');
                $this->_controller = new AccueilController($url);
            }
        }
        catch (Exception $e)
        {
            $errorMessage = $e->getMessage();
            $this->_view = new View('global/error');
            $this->_view->generate(['errorMessage' => $errorMessage]);

        }
    }
}
<?php

require_once('_ControllerClass.php');

class PlongeeController extends _ControllerClass
{
    private $plongeeManager;

    public function __construct($url)
    {
        $this->plongeeManager = new PlongeeManager();

        $urlSize = parent::__construct($url);

        if ($urlSize > 1)
            if($url[1] == 'show')
                $this->show();
            else
                throw new Exception('Page introuvable');
    }

    /**
     * Fonction chargée au chargement de la page.
     * @throws Exception
     */
    public function index()
    {
        $this->add();
        var_dump($this->plongeeManager->getAll());
        (new View('plongee/plongee_index'))->generate([
            'allPlongees' => $this->plongeeManager->getAll()
        ]);
    }

    public function show()
    {
        if (!isset($_GET['plo_date']) || !isset($_GET['PLO_MAT_MID_SOI']))
            header('location: plongee');

        $plongee = $this->plongeeManager->getOne([
            'PLO_DATE' => $_GET['plo_date'],
            'PLO_MAT_MID_SOI' => $_GET['PLO_MAT_MID_SOI']]);

        if (is_null($plongee))
            header('location: plongee');

        if ( isset($_POST['submit']) )
            $this->verification($plongee);

        (new View('plongee/plongee_show/plongee_show_index'))->generate([
            'plongee' => $plongee,
        ]);
    }

    public function edit()
    {

    }

    private function add()
    {
        // Ajout d'une plongee
    }

    private function verification($plongeur)
    {
        header('location: /plongee');
    }
}
<?php

require_once('_ControllerClass.php');

class PlongeeController extends _ControllerClass
{
    private $plongeeManagers;

    public function __construct($url)
    {
        $this->plongeeManagers = new PlongeeManager();

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

        (new View('plongee/plongee_index'))->generate([
            'allPlongees' => $this->plongeeManagers->getAll()
        ]);
    }

    public function show()
    {
        if (!isset($_GET['plo_date']) || !isset($_GET['plo_matin_apresmidi']))
            header('location: plongee');

        $plongee = $this->plongeeManagers->getOne([
            'PLO_DATE' => $_GET['plo_date'],
            'PLO_MATIN_APRESMIDI' => $_GET['plo_matin_apresmidi']]);

        if (is_null($plongee))
            header('location: plongee');

        if ( isset($_POST['submit']) )
            $this->verification($plongee);

        (new View('plongee/plongee_show/plongee_show_index'))->generate([
            'plongee' => $plongee,
        ]);
    }

    private function add()
    {
        if ( isset($_POST['submit']) ) {
            $plongeur = new Plongeur($_POST);
            $this->verification($plongeur);

        }
    }

    private function verification($plongeur)
    {
        // Fonction de vérification d'une plongée, utile ?
    }
}
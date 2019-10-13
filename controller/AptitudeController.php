<?php

require_once('_ControllerClass.php');

class AptitudeController extends _ControllerClass
{
    private $aptitudeManager;

    public function __construct($url)
    {
        $this->aptitudeManager = new AptitudeManager();

        $urlSize = parent::__construct($url);

        if ($urlSize > 1)
            if($url[1] == 'edit')
                $this->edit();
            else
                throw new Exception('Page introuvable');
    }

    /**
     * Fonction chargée au chargement de la page.
     * @throws Exception
     */
    public function index()
    {
        if (isset($_POST['submit']))
            $this->add();

        $searchedAptitudes = null;

        if ( isset($_POST['search']) ) {

            if (!empty($_POST['searchCode']))
                $search['code'] = $_POST['searchCode'];

            if (!empty($_POST['searchLibelle']))
                $search['libelle'] = $_POST['searchLibelle'];

            if (!empty($_POST['searchCode']) || !empty($_POST['searchLibelle']))
                $searchedAptitudes = $this->aptitudeManager->getSearchResult($search);

        }

        (new View('aptitude/aptitude_index'))->generate([
            'allAptitudes' => $this->aptitudeManager->getAll(),
            'searchedAptitudes' => $searchedAptitudes
        ]);
    }

    public function edit()
    {
        if (!isset($_GET['apt_code']))
            header('location: aptitude');

        $aptitude = $this->aptitudeManager->getOne([
            'APT_CODE' => $_GET['apt_code']]);

        if (is_null($aptitude))
            header('location: aptitude');

        if ( isset($_POST['submit']) )
            $this->verification($aptitude);

        (new View('aptitude/aptitude_editform'))->generate([
            'aptitude' => $aptitude,
        ]);
    }

    private function add()
    {
        if ( isset($_POST['submit']) ) {
            $aptitude = new Aptitude($_POST);
            $this->verification($aptitude);
        }
    }

    private function verification($aptitude)
    {
        if (!empty($_POST['code']) && !empty($_POST['libelle'])) {
            $code = strtoupper($_POST['code']);
            $libelle = ucfirst($_POST['libelle']);

            $aptitudes = $this->aptitudeManager->getAll();

            $nbAptitudes = count($aptitudes);

            $i = 0;

            if ($code != $aptitude[0]->getAptCode())
                while (($code != $aptitudes[$i]->getAptCode()) && (++$i < $nbAptitudes)) ;
            else
                $i = $nbAptitudes;

            if ($i == $nbAptitudes) {
                $aptitude[0]->setAptCode($code);
                $aptitude[0]->setAptLibelle($libelle);
                $this->aptitudeManager->update($aptitude);
                header('location: /aptitude');
            } else
                echo 'Aptitude déjà enregistrée.';
        }
    }
}
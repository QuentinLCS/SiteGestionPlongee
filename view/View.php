<?php


/**
 * Class View
 */
class View
{
    /**
     * @var string
     */
    private $_file;

    /**
     * @var
     */
    private $_title;

    /**
     * View constructor.
     * @param $action
     */
    public function __construct($action)
    {
        $this->_file = 'view/'.$action.'.html';
    }

    /**
     * @param $data
     * @param bool $blank
     * @throws Exception
     */
    public function generate($data, $blank = false)
    {
        $view = $this->generateFile($this->_file, $data);

        if (!$blank)
            $view = $this->generateFile('view/base.html', ['title' => $this->_title, 'content' => $view]);

        echo $view;

    }

    /**
     * @param $file
     * @param $data
     * @return false|string
     * @throws Exception
     */
    private function generateFile($file, $data)
    {
        if (file_exists($file))
        {
            extract($data);

            ob_start();

            require($file);

            return ob_get_clean();
        }
        else
            throw new Exception('Fichier '.$file.' introuvable !');
    }
}
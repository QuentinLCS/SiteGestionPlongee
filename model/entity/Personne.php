<?php

require_once('_Entity.php');

class Personne extends _Entity
{
    private $per_num;

    private $per_nom;

    private $per_prenom;

    private $per_active;

    private $per_date_certify_med;


    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    /**
     * @return mixed
     */
    public function getPerNum()
    {
        return $this->per_num;
    }

    /**
     * @param mixed $per_num
     */
    public function setPerNum($per_num)
    {
        $this->per_num = $per_num;
    }

    /**
     * @return mixed
     */
    public function getPerNom()
    {
        return $this->per_nom;
    }

    /**
     * @param mixed $per_nom
     */
    public function setPerNom($per_nom)
    {
        $this->per_nom = $per_nom;
    }

    /**
     * @return mixed
     */
    public function getPerPrenom()
    {
        return $this->per_prenom;
    }

    /**
     * @param mixed $per_prenom
     */
    public function setPerPrenom($per_prenom)
    {
        $this->per_prenom = $per_prenom;
    }

    /**
     * @return mixed
     */
    public function getPerActive()
    {
        return $this->per_active;
    }

    /**
     * @param mixed $per_active
     */
    public function setPerActive($per_active)
    {
        $this->per_active = $per_active;
    }

    /**
     * @return mixed
     */
    public function getPerDateCertifyMed()
    {
        return $this->per_date_certify_med;
    }

    /**
     * @param mixed $per_date_certify_med
     */
    public function setPerDateCertifyMed($per_date_certify_med)
    {
        $this->per_date_certify_med = $per_date_certify_med;
    }

    // Correcteurs de chaines

    private function specialCharConverter($text) {
        $regex = [
            '#ý#s' => 'y',
            '#Ý#s' => 'Y',
            '#Æ#s' => 'ae',
            '#æ#s' => 'ae',
            '#Œ#s' => 'oe',
            '#œ#s' => 'oe',
            '#ñ#s' => 'n',
            '#ŭ#i' => 'u',
            '#Ŭ#i' => 'u',
            '#ø#i' => 'o',
            '#ã|å#' => 'a',
            '#Ã|Å#' => 'A',
            '#ð|õ|ø#s' => 'o',
            '#Õ#' => 'O',
            '#ũ#' => 'u',
            '#Ũ#' => 'U',
            '#Ç#' => 'C',
            '#ç#', 'c',
            '#è|é|ê|ë#', 'e',
            '#È|É|Ê|Ë#', 'E',
            '#à|á|â|ã|ä|å#', 'a',
            '#À|Á|Â|Ã|Ä|Å#', 'A',
            '#ì|í|î|ï#', 'i',
            '#Ì|Í|Î|Ï#', 'I',
            '#ð|ò|ó|ô|õ|ö|ø#s', 'o',
            '#Ò|Ó|Ô|Õ|Ö#', 'O',
            '#ũ|ù|ú|û|ü#', 'u',
            '#Ũ|Ù|Ú|Û|Ü#', 'U',
            '#Ÿ#', 'Y',
            '#ÿ#', 'y'
            ];
        return preg_replace(array_keys($regex), array_values($regex), $text);
    }

    private function firstLetterConverter($text) {
        $regex = [
            '#^Ç#' => 'C',
            '#^ç#' => 'c',
            '#^è|^é|^ê|^ë#' => 'e',
            '#^È|^É|^Ê|^Ë#' => 'E',
            '#^à|^á|^â|^ã|^ä|^å#' => 'a',
            '#^À|^Á|^Â|^Ã|^Ä|^Å#' => 'A',
            '#^ì|^í|^î|^ï#' => 'i',
            '#^Ì|^Í|^Î|^Ï#' => 'I',
            '#^ð|^ò|^ó|^ô|^õ|^ö|^ø#s' => 'o',
            '#^Ò|^Ó|^Ô|^Õ|^Ö#' => 'O',
            '#^ũ|^ù|^ú|^û|^ü#' => 'u',
            '#^Ũ|^Ù|^Ú|^Û|^Ü#' => 'U'
        ];
        return preg_replace(array_keys($regex), array_values($regex), $text);
    }

    private function AutoCapsOnFirstname($text) {
        $prenom = mb_strtolower($text, 'UTF-8');
        $prenom = capsOnWordStart($prenom, "-");
        $prenom = capsOnWordStart($prenom, " ");
        $prenom = capsOnWordStart($prenom, "'");
        return $prenom;
    }

    private function capsOnWordStart($text, $limitor) {
        $tabPrenom = mb_split($limitor, $text);
        $prenom = '';
        foreach ($tabPrenom as $indice => $contenu) {
            $tabPrenom[$indice] = majusculeDebut($tabPrenom[$indice]);
            if ($indice == 0) {
                $prenom = $tabPrenom[$indice];
            } else $prenom = $prenom . $limitor . $tabPrenom[$indice];
        }
        return $prenom;
    }

    private function deleteSpaces($text) {
        $ch = trim($text); //Supprime espace début & fin

        $regex = [
            '# {2,}#' => ' ',
            '#\s+-\s+|-\s+|\s+-#' => '-', //Supprime espace avant/après -
            '#\s\'\s#' => " '",
        ];

        return preg_replace(array_keys($regex), array_values($regex), $text);
    }

    private function hiphenLimiter($text) {

        $regex = [
            '#^-{1,}#' => '',
            '#-{1,}$#' => ''
        ];

        return preg_replace(array_keys($regex), array_values($regex), $text);
    }


/*
    private function majusculeDebut($ch) {
        $premiere = mb_substr($ch, 0, 1, 'UTF-8');
        $premiere = convertirAccentDebutMot($premiere);
        $premiere = mb_strtoupper($premiere, 'UTF-8');
        $longueur = mb_strlen($ch, 'UTF-8');
        return $premiere . mb_substr($ch, 1, $longueur - 1, 'UTF-8');
    }
*/

    // Vérificateurs de chaines

    /*
    private function formatNomCorrect($chaine) {
        $modele = '/[a-zA-Z-\'àâäçéèêëîïôöùûüÿ\s]{1,}/';
        return preg_match($modele, $chaine, $data) && $data[0] == $chaine && mb_strlen($chaine) <= 30;
    }

    private function formatLocaliteCorrect($chaine) {
        $modele = '#[^a-zA-Z\-\'0-9àâäçéèêëîïôöùûüÿ ]#';
        return preg_match($modele, $chaine, $data) && $data[0] == $chaine;
    }

    private function formatPrenomCorrect($chaine) {
        $modele = '/[a-zA-Z-\'àâäçéèêëîïôöùûüÿ\s]{1,}/';
        return preg_match($modele, $chaine, $data) && $data[0] == $chaine && mb_strlen($chaine, 'UTF-8') <= 30;
    }
    */

    private function formatChaineChiffreCorrect($chaine) {
        $modele = '#[^0-9]*#';
        return !preg_match($modele, $chaine);
    }

    private function espaceCorrect($chaine) {
        $modele = '#\s{2,}#';
        return !preg_match($modele, $chaine);
    }

    private function tiretCorrectNom($chaine)
    {
        $modele = '#^-|-$|-{3,}#';
        return !(preg_match($modele, $chaine) || countDoubleTirets($chaine) > 2 || verificationTiretApostrophe($chaine));
    }
    private function tiretCorrectPrenom($chaine) {
        $modele = '#^-|-$|-{3,}#';
        return !(preg_match($modele, $chaine) || countDoubleTirets($chaine) > 1 || verificationTiretApostrophe($chaine));
    }

    private function countDoubleTirets($chaine) {
        $tab = explode('--', $chaine);
        return count($tab);
    }

    private function verificationTiretApostrophe($chaine) {
        return preg_match("/-'$|^'-/", $chaine);
    }

    private function apostropheCorrect($ch) {
        return !preg_match('#\'{2,}|^\'$#', $ch);
    }

    private function nomCorrect($ch) {
        return formatNomCorrect($ch) && tiretCorrectNom($ch) && espaceCorrect($ch) && apostropheCorrect($ch);
    }

    private function prenomCorrect($ch) {
        return formatPrenomCorrect($ch) && tiretCorrectPrenom($ch) && espaceCorrect($ch) && apostropheCorrect($ch);
    }

    private function traitementNom($ch) {
        $nom = convertirCaractereSpecial($ch);
        $nom = supprimerTiret($nom);
        $nom = convertirAccent($nom);
        $nom = convertirMajuscule($nom);
        $nom = supprimerEspace($nom);
        if (!nomCorrect($nom)) {
            return false;
        }
        return $nom;
    }

    private function traitementPrenom($ch) {
        $prenom = convertirCaractereSpecial($ch);
        $prenom = supprimerEspace($prenom);
        $prenom = supprimerTiret($prenom);
        $prenom = convertirMajusculePrenom($prenom);
        if (!prenomCorrect($prenom)) {
            return false;
        }
        return $prenom;
    }

}
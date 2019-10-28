<?php
// Correcteurs de chaines

function specialCharConverter($text) {
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
        '#ç#' =>  'c',
        '#è|é|ê|ë#' =>  'e',
        '#È|É|Ê|Ë#' =>  'E',
        '#à|á|â|ã|ä|å#' =>  'a',
        '#À|Á|Â|Ã|Ä|Å#' =>  'A',
        '#ì|í|î|ï#' =>  'i',
        '#Ì|Í|Î|Ï#' =>  'I',
        '#ð|ò|ó|ô|õ|ö|ø#s' =>  'o',
        '#Ò|Ó|Ô|Õ|Ö#' =>  'O',
        '#ũ|ù|ú|û|ü#' =>  'u',
        '#Ũ|Ù|Ú|Û|Ü#' =>  'U',
        '#Ÿ#' =>  'Y',
        '#ÿ#' =>  'y'
    ];
    return preg_replace(array_keys($regex), array_values($regex), $text);
}

function firstLetterAccentConverter($text) {
    $regex = [
        '#^ì|^í|^î|^ï#' => 'i',
        '#^Ì|^Í|^Î|^Ï#' => 'I',
        '#^è|^é|^ê|^ë#' => 'e',
        '#^È|^É|^Ê|^Ë#' => 'E',
        '#^à|^á|^â|^ã|^ä|^å#' => 'a',
        '#^À|^Á|^Â|^Ã|^Ä|^Å#' => 'A',
        '#^ð|^ò|^ó|^ô|^õ|^ö|^ø#s' => 'o',
        '#^Ò|^Ó|^Ô|^Õ|^Ö#' => 'O',
        '#^ũ|^ù|^ú|^û|^ü#' => 'u',
        '#^Ũ|^Ù|^Ú|^Û|^Ü#' => 'U',
        '#^ç#' => 'c',
        '#^Ç#' => 'C'
    ];
    return preg_replace(array_keys($regex), array_values($regex), $text);
}

function AutoCapsOnFirstname($text) {
    $prenom = mb_strtolower($text, 'UTF-8');
    $prenom = capsOnWordStart($prenom, "-");
    $prenom = capsOnWordStart($prenom, " ");
    $prenom = capsOnWordStart($prenom, "'");
    return $prenom;
}

function hiphenLimiter($text) {

    $regex = [
        '#^-{1,}#' => '',
        '#-{1,}$#' => ''
    ];

    return preg_replace(array_keys($regex), array_values($regex), $text);
}


function capsOnWordStart($text, $limitor) {
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

function deleteSpaces($text) {
    $ch = trim($text); //Supprime espace début & fin

    $regex = [
        '# {2,}#' => ' ',
        '#\s+-\s+|-\s+|\s+-#' => '-', //Supprime espace avant/après -
        '#\s\'\s#' => " '",
    ];

    return preg_replace(array_keys($regex), array_values($regex), $text);
}




function majusculeDebut($ch) {
    $premiere = mb_substr($ch, 0, 1, 'UTF-8');
    $premiere = firstLetterAccentConverter($premiere);
    $premiere = mb_strtoupper($premiere, 'UTF-8');
    $longueur = mb_strlen($ch, 'UTF-8');
    return $premiere . mb_substr($ch, 1, $longueur - 1, 'UTF-8');
}


// Vérificateurs de chaines


function formatNomCorrect($chaine) {
    $modele = '/[a-zA-Z-\'àâäçéèêëîïôöùûüÿ\s]{1,}/';
    return preg_match($modele, $chaine, $data) && $data[0] == $chaine && mb_strlen($chaine) <= 30;
}

function formatLocaliteCorrect($chaine) {
    $modele = '#[^a-zA-Z\-\'0-9àâäçéèêëîïôöùûüÿ ]#';
    return preg_match($modele, $chaine, $data) && $data[0] == $chaine;
}

function formatPrenomCorrect($chaine) {
    $modele = '/[a-zA-Z-\'àâäçéèêëîïôöùûüÿ\s]{1,}/';
    return preg_match($modele, $chaine, $data) && $data[0] == $chaine && mb_strlen($chaine, 'UTF-8') <= 30;
}


function formatChaineChiffreCorrect($chaine) {
    $modele = '#[^0-9]*#';
    return !preg_match($modele, $chaine);
}

function espaceCorrect($chaine) {
    $modele = '#\s{2,}#';
    return !preg_match($modele, $chaine);
}

function tiretCorrectNom($chaine)
{
    $modele = '#^-|-$|-{3,}#';
    return !(preg_match($modele, $chaine) || countDoubleTirets($chaine) > 2 || verificationTiretApostrophe($chaine));
}
function tiretCorrectPrenom($chaine) {
    $modele = '#^-|-$|-{3,}#';
    return !(preg_match($modele, $chaine) || countDoubleTirets($chaine) > 1 || verificationTiretApostrophe($chaine));
}

function countDoubleTirets($chaine) {
    $tab = explode('--', $chaine);
    return count($tab);
}

function verificationTiretApostrophe($chaine) {
    return preg_match("/-'$|^'-/", $chaine);
}

function apostropheCorrect($ch) {
    return !preg_match('#\'{2,}|^\'$#', $ch);
}

function nomCorrect($ch) {
    return formatNomCorrect($ch) && tiretCorrectNom($ch) && espaceCorrect($ch) && apostropheCorrect($ch);
}

function prenomCorrect($ch) {
    return formatPrenomCorrect($ch) && tiretCorrectPrenom($ch) && espaceCorrect($ch) && apostropheCorrect($ch);
}

function traitementNom($ch) {
    $nom = specialCharConverter($ch);
    var_dump($nom);
    $nom = hiphenLimiter($nom);
    var_dump($nom);
   // $nom = convertirAccent($nom);
    $nom = strtoupper($nom);
    var_dump($nom);
    $nom = deleteSpaces($nom);
    var_dump($nom);
    if (!nomCorrect($nom)) {
        return false;
    }
    return $nom;
}

function traitementPrenom($ch) {
    //$prenom = specialCharConverter($ch);
    $prenom = deleteSpaces($ch);
    $prenom = hiphenLimiter($prenom);
    $prenom = AutoCapsOnFirstname($prenom);
    if (!prenomCorrect($prenom)) {
        return false;
    }
    return $prenom;
}
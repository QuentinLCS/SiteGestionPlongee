<?php
/*
//converti caractères spéciaux
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

//converti le premier caractère d'un prénom
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


function traitementNom($txt) {
    $nom = specialCharConverter($txt); //transforme les caractères spéciaux
    $nom = hiphenLimiter($nom); // enlève les tirets au début et à la fin
    $nom = strtoupper($nom); //Met en majuscule
    $nom = deleteSpaces($nom); //supprime espaces au début et à la fin
    if (!FormatNomOK($nom) && !tiretNomOK($nom) && !espaceOK($nom) && !apostropheOK($nom))  {
        return false;
    }
    return $nom;
}

//retire un tiret au début ou à la fin du nom
function hiphenLimiter($text) {
    $regex = [
        '#^-{1,}#' => '',
        '#-{1,}$#' => ''
    ];
    return preg_replace(array_keys($regex), array_values($regex), $text);
}

function FormatNomOK($text) {
    $modele = '/[a-zA-Z-\'àâäçéèêëîïôöùûüÿ\s]{1,}/';
    return preg_match($modele, $text, $tab) && $tab[0] == $text;
}

function tiretNomOK($text)
{
    $modele = '#^-|-$|-{3,}#';
    $tab = explode('--', $text);
    return !(preg_match($modele, $text) || count($tab)> 2 || tiretAvecApostrophe($text));
}

function espaceOK($text) {
    $modele = '#\s{2,}#';
    return !preg_match($modele, $text);
}

function apostropheOK($text) {
    return !preg_match('#\'{2,}|^\'$#', $text);
}

function tiretAvecApostrophe($chaine) {
    return preg_match("/-'$|^'-/", $chaine);
}


function traitementPrenom($txt) {
    $prenom = specialCharConverter($txt); //transforme les caractères spéciaux
    $prenom = deleteSpaces($prenom);
    $prenom = hiphenLimiter($prenom);
    $prenom = AutoCapsOnFirstname($prenom);
    if (!formatPrenomOK($prenom) && !tiretPrenomOK($prenom) && !espaceOK($prenom) && !apostropheOK($prenom)) {
        return false;
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

function AutoCapsOnFirstname($text) {
    $prenom = mb_strtolower($text, 'UTF-8');
    $prenom = capsOnWordStart($prenom, "-");
    $prenom = capsOnWordStart($prenom, " ");
    $prenom = capsOnWordStart($prenom, "'");
    return $prenom;
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

function majusculeDebut($ch) {
    $premiere = mb_substr($ch, 0, 1, 'UTF-8');
    $premiere = firstLetterAccentConverter($premiere);
    $premiere = mb_strtoupper($premiere, 'UTF-8');
    $longueur = mb_strlen($ch, 'UTF-8');
    return $premiere . mb_substr($ch, 1, $longueur - 1, 'UTF-8');
}

function formatPrenomOK($chaine) {
    $modele = '/[a-zA-Z-\'àâäçéèêëîïôöùûüÿ\s]{1,}/';
    return preg_match($modele, $chaine, $data) && $data[0] == $chaine && mb_strlen($chaine, 'UTF-8') <= 30;
}

function tiretPrenomOK($chaine) {
    $modele = '#^-|-$|-{3,}#';
    $tab = explode('--', $chaine);
    return !(preg_match($modele, $chaine) || count($tab) > 2 || tiretAvecApostrophe($chaine));
}

*/
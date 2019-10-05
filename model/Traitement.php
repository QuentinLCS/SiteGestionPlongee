<?php


function enleverCaracteresSpeciaux($text)
{
    $utf8 = array(
        '/[áàâãªä]/u' => 'a',
        '/[ÁÀÂÃÄ]/u' => 'A',
        '/[ÍÌÎÏ]/u' => 'I',
        '/[íìîï]/u' => 'i',
        '/[éèêë]/u' => 'e',
        '/[ÉÈÊË]/u' => 'E',
        '/[óòôõºö]/u' => 'o',
        '/[ÓÒÔÕÖ]/u' => 'O',
        '/[úùûü]/u' => 'u',
        '/[ÚÙÛÜ]/u' => 'U',
        '/ç/' => 'c',
        '/Ç/' => 'C',
        '/ñ/' => 'n',
        '/Ñ/' => 'N',
        //'//' => '-', // conversion d'un tiret UTF-8 en un tiret simple
        '/\[\]/u' => ' ', // guillemet simple
        '/[«»]/u' => ' ', // guillemet double
        '/ /' => ' ', // espace insécable (équiv. à 0x160)
        'œ' => 'oe',
        'æ' => 'ae'
    );

    return preg_replace(array_keys($utf8), array_values($utf8), $text);
}
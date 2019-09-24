<?php

if (empty($_POST)) {

    $erreur = false;
    if (isset($_POST["date"])) {
        $date = $_POST["date"];
    } else {
        $erreur = true;
    }

    if (isset($_POST["periode"])) {
        $periode = ($_POST["periode"]);
    } else {
        $erreur = true;
    }

    if (isset($_POST["site"]) && $_POST["site"] != "") {
        $site = $_POST["site"];
    } else {
        $erreur = true;
    }

    if (isset($_POST["embarcation"])) {
        $embarcation = $_POST["embarcation"];
    } else {
        $erreur = true;
    }

    if (isset($_POST["effectifP"]) && $_POST["effectifP"] != "") {
        $effectifP = $_POST["effectifP"];
    } else {
        $erreur = true;
    }

    if (isset($_POST["effectifB"]) && $_POST["effectifB"] != "") {
        $effectifB = $_POST["effectifB"];
    } else {
        $erreur = true;
    }

    if (isset($_POST["directeur"]) && $_POST["directeur"] != "") {
        $directeur = $_POST["directeur"];
    } else {
        $erreur = true;
    }

    if (isset($_POST["securite"]) && $_POST["securite"] != "") {
        $securite = $_POST["securite"];
    } else {
        $erreur = true;
    }


}
if ($erreur == true) {

}

<?php
    include('../view/formNewPlongeur.html');

    include_once('../model/Traitement.php');

    if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&&isset($_POST['competence']))
    {
        echo "bien";
    }
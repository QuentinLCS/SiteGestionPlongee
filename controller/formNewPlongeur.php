<?php
    include('../view/formNewPlongeur.html');
    if(!empty($_POST['nom'])&&!empty($_POST['prenom'])&&isset($_POST['competence']))
    {
        echo "bien";
    }
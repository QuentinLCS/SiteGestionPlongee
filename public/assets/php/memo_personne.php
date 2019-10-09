<?php
    function verifierEntree($champ)
{
    if($_POST["$champ"]!=null)
    {
        echo $_POST["$champ"];
    }
}
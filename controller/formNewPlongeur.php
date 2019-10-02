<body>
    <form action="<?php $_SERVER["php_self"]?>" method="post">
        <label for="nom">Nom : </label><input type="text" id="nom" name="nom" placeholder="Saisir le nom"><br>
        <label for="prenom">Prenom : </label><input type="text" id="prenom" name="prenom" placeholder="Saisir le prenom"><br>
        <select id="competence" name="competence">
            <?php
                /*$req="select * from PLO_APTITUDE";
                $reponse = LireDonnePDO2($db,$req);
                var_dump($reponse);*/
            ?>
        </select>
        <Button type="submit">Enregistrer</Button>
    </form>
</body>
<?php
    $modele ="";
    if(isset($_POST['nom'])&& isset($_POST['prenom']))
    {
        echo 'test';
    }

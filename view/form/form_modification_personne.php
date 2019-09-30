<form action="../../controller/modification_personne.php">
    <label>
        Nom
        <input type="text" id="nom" name="nom" value="<?php echo $resultat[0]['PER_NOM'] ?>">
    </label>
    <label>
        Prénom
        <input type="text" id="prenom" name="prenom" value="<?php echo $resultat[0]['PER_PRENOM'] ?>">
    </label>
</form>
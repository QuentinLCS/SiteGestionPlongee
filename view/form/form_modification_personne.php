<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
    <label>
        Nom
        <input type="text" id="nom" name="nom" value="<?php echo $resultat[0]['PER_NOM'] ?>">
    </label>
    <label>
        Prénom
        <input type="text" id="prenom" name="prenom" value="<?php echo $resultat[0]['PER_PRENOM'] ?>">
    </label>
    <button class="btn" name="submit">MODIFIER</button>
</form>

<?php
    if ( isset($_POST['submit']) ) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $id = $_GET['id'];
        $cur = $db->preparerRequetePDO("UPDATE PLO_PERSONNE SET PER_NOM = '$nom' , PER_PRENOM = '$prenom' WHERE PER_NUM = '$id'");
        $db->majDonneesPrepareesPDO($cur);
    }
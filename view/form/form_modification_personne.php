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
        if ( !empty($_POST['nom']) && !empty($_POST['prenom']) ) {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];

            $db->LireDonneesPDO2("SELECT * FROM PLO_PERSONNE", $personnes);

            $nbPersonnes = count($personnes);

            $i = 0;

            // Si le prénom ou le nom a été modifié
            if ($nom != $resultat[0]['PER_NOM'] || $prenom != $resultat[0]['PER_PRENOM'])
                while (($nom != $personnes[$i]['PER_NOM'] || $prenom != $personnes[$i]['PER_PRENOM']) && ++$i < $nbPersonnes);
            else
                $i = $nbPersonnes;


            if ($i == $nbPersonnes) {
                $id = $_GET['id'];
                $cur = $db->preparerRequetePDO("UPDATE PLO_PERSONNE SET PER_NOM = '$nom' , PER_PRENOM = '$prenom' WHERE PER_NUM = '$id'");
                $db->majDonneesPrepareesPDO($cur);
                header("Refresh:0");
            } else
                echo "Personne déjà enregistrée.";
        }
    }
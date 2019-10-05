<p class="red lighten-4 red-text text-darken-4 center" id="form-error">

</p>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
    <label>
        Nom
        <input type="text" id="nom" name="nom" value="<?php echo $utilisateur[0]['PER_NOM'] ?>">
    </label>
    <label>
        Prénom
        <input type="text" id="prenom" name="prenom" value="<?php echo $utilisateur[0]['PER_PRENOM'] ?>">
    </label>
    <label>
        <select name="aptitude" id="aptitude">
            <?php
            foreach ($aptitudes as $aptitude)
                echo '<option value="'. $aptitude['APT_CODE'] .'" '. ($aptitude['APT_CODE'] == $utilisateur[0]['APT_CODE'] ? 'selected' : '') .'>'. $aptitude['APT_LIBELLE'] .'</option>';
            ?>

        </select>
    </label>
    <button class="btn" name="submit">MODIFIER</button>
</form>

<script type="text/javascript" src="assets/js/personne_entree.js"></script>
<?php
    include_once('../model/Traitement.php');

    if ( isset($_POST['submit']) ) {
        if ( !empty($_POST['nom']) && !empty($_POST['prenom']) ) {
            $nom = strtoupper(enleverCaracteresSpeciaux($_POST['nom']));
            $prenom = ucfirst(enleverCaracteresSpeciaux($_POST['prenom']));
            $aptitude = $_POST['aptitude'];

            $db->LireDonneesPDO2('SELECT * FROM PLO_PERSONNE', $personnes);

            $nbPersonnes = count($personnes);

            $i = 0;

            // Si le prénom ou le nom a été modifié
            if ($nom != $utilisateur[0]['PER_NOM'] || $prenom != $utilisateur[0]['PER_PRENOM'])
                while (($nom != $personnes[$i]['PER_NOM'] || $prenom != $personnes[$i]['PER_PRENOM']) && ++$i < $nbPersonnes);
            else
                $i = $nbPersonnes;


            if ($i == $nbPersonnes) {
                $id = $_GET['id'];
                $cur = $db->preparerRequetePDO("UPDATE PLO_PERSONNE SET PER_NOM = '$nom' , PER_PRENOM = '$prenom' WHERE PER_NUM = '$id'");
                $db->majDonneesPrepareesPDO($cur);
                $cur = $db->preparerRequetePDO("UPDATE PLO_PLONGEUR SET APT_CODE = '$aptitude' WHERE PER_NUM = '$id'");
                $db->majDonneesPrepareesPDO($cur);
                header("Location: ../public/?page=plongeur");
            } else
                echo "Personne déjà enregistrée.";
        }
    }
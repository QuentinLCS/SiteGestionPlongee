<div>
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
</div>

<script type="text/javascript" src="assets/js/personne_entree.js"></script>
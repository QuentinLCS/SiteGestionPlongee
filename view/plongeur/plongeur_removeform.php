<form method="post" action="<?php $_SERVER["PHP_SELF"] ?>" style="display: inline-block;" class="no-padding">
    <input type="hidden" value="<?php echo $value["PER_NUM"] ?>">
    <button type="submit" name="<?php echo $value["PER_NUM"] ?>" class="btn red darken-4 waves-effect waves-light tooltipped" data-position="top" data-tooltip="Supprimer"><i class="material-icons white-text">delete</i></button>
</form>
<?php
    $idUti = $value["PER_NUM"];
    if(isset($_POST[$idUti])) {

        $req2 = 'SELECT PAL_NUM FROM PLO_PLONGEUR JOIN PLO_CONCERNER USING(PER_NUM) JOIN PLO_PALANQUEE USING(PAL_NUM) WHERE PER_NUM = '.$idUti;
        $db->LireDonneesPDO2($req2, $tab2);

        //vérifie si le plongeur a des plongées
        if (count($tab2) == 0) {
            $req3 = 'DELETE FROM PLO_PLONGEUR WHERE PER_NUM = '.$idUti;
            $cur = $db->preparerRequetePDO($req3);
            $db->majDonneesPrepareesPDO($cur);
        } else {
            echo "vous ne pouvez pas supprimer ce plongeur car il a des plongées";
            $req4 = 'UPDATE PLO_PERSONNE SET PER_ACTIVE = 0 WHERE PER_NUM = '.$idUti;
            $cur = $db->preparerRequetePDO($req4);
            $db->majDonneesPrepareesPDO($cur);
        }
    }
?>
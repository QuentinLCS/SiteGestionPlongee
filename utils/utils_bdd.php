<?php

class DataBase extends PDO
{

    private $conn; // contiendra l'objet PDO

    function __construct($dsn, $username = null, $passwd = null, $options = null)
    {
        try {
            parent::__construct($dsn, $username, $passwd, $options);
        } catch (PDOException $e) {
            print_r($e);
        }
    }

    function OuvrirConnexionPDO($db, $db_username, $db_password)
    {
        try {
            $this->conn = new PDO($db, $db_username, $db_password);
            $res = true;
        } catch (PDOException $erreur) {
            echo $erreur->getMessage();
        }
        return $this->conn;
    }

    //---------------------------------------------------------------------------------------------
    function majDonneesPDO($sql)
    {
        $stmt = $this->conn->exec($sql);
        return $stmt;
    }

    //---------------------------------------------------------------------------------------------
    function preparerRequetePDO($sql)
    {
        $cur = $this->conn->prepare($sql);
        return $cur;
    }

    //---------------------------------------------------------------------------------------------
    function ajouterParamPDO($cur, $param, $contenu, $type = 'texte', $taille = 0) // fonctionne avec preparerRequete
    {
        // Sur Oracle, on peut tout passer sans préciser le type. Sur MySQL ???
        //	if ($type == 'nombre')
        //		$cur->bindParam($param, $contenu, PDO::PARAM_INT);
        //	else
        //$cur->bindParam($param, $contenu, PDO::PARAM_STR, $taille);
        $cur->bindParam($param, $contenu);
        return $cur;
    }

    //---------------------------------------------------------------------------------------------
    function majDonneesPrepareesPDO($cur) // fonctionne avec ajouterParam
    {
        $res = $cur->execute();
        return $res;
    }

    //---------------------------------------------------------------------------------------------
    function majDonneesPrepareesTabPDO($cur, $tab) // fonctionne directement après preparerRequete
    {
        $res = $cur->execute($tab);
        return $res;
    }

    //---------------------------------------------------------------------------------------------
    function LireDonneesPDO1($sql, &$tab)
    {
        $i = 0;
        foreach ($this->conn->query($sql, PDO::FETCH_ASSOC) as $ligne) // ici que ça se gère pour les lignes ou colonne
            $tab[$i++] = $ligne;
        $nbLignes = $i;
        return $nbLignes;
    }

    //---------------------------------------------------------------------------------------------
    function LireDonneesPDO2($sql, &$tab)
    {
        $i = 0;
        $cur = $this->conn->query($sql);
        while ($ligne = $cur->fetch(PDO::FETCH_ASSOC))
            $tab[$i++] = $ligne;
        $nbLignes = $i;
        return $nbLignes;
    }

    //---------------------------------------------------------------------------------------------
    function LireDonneesPDO3($sql, &$tab)
    {
        $cur = $this->conn->query($sql);
        $tab = $cur->fetchall(PDO::FETCH_ASSOC);
        return count($tab);
    }

    //---------------------------------------------------------------------------------------------
    function LireDonneesPDOPreparee($cur, &$tab)
    {
        $res = $this->cur->execute();
        $tab = $cur->fetchall(PDO::FETCH_ASSOC);
        return count($tab);
    }
}

//---------------------------------------------------------------------------------------------
// fonctions supplementaires
//---------------------------------------------------------------------------------------------
function fabriquerChaineConnexPDO()
{
    $hote = 'localhost';
    $port = '1521'; // port par défaut
    $service = 'localhost';

    $db =
        "oci:dbname=(DESCRIPTION =
	(ADDRESS_LIST =
		(ADDRESS =
			(PROTOCOL = TCP)
			(Host = " . $hote . ")
			(Port = " . $port . "))
	)
	(CONNECT_DATA =
		(SERVICE_NAME = " . $service . ")
	)
	)";
    return $db;
}


function AfficherDonnee1($tab,$nbLignes)
{
    if ($nbLignes > 0)
    {
        echo "<table border=\"1\">\n";
        echo "<tr>\n";
        foreach ($tab as $key => $val)  // lecture des noms de colonnes
        {
            echo "<th>$key</th>\n";
        }
        echo "</tr>\n";
        echo $nbLignes;
        for ($i = 0; $i < $nbLignes; $i++) // balayage de toutes les lignes
        {
            echo "<tr>\n";
            foreach ($tab as $data) // lecture des enregistrements de chaque colonne
            {
                echo "<td>$data[$i]</td>\n";
            }
            echo "</tr>\n";
        }
        echo "</table>\n";
    }
    else
    {
        echo "Pas de ligne<br />\n";
    }
    echo "$nbLignes Lignes lues<br />\n";
}

//---------------------------------------------------------------------------------------------
function AfficherDonnee2($tab)
{
    foreach($tab as $ligne)
    {
        foreach($ligne as $valeur)
            echo $valeur." ";
        echo "<br/>";
    }
}
//---------------------------------------------------------------------------------------------
function AfficherDonnee3($tab,$nb)
{
    for($i=0;$i<$nb;$i++)
        echo $tab[$i][0]." ".$tab[$i][1]." ".$tab[$i][2]."\n";
}
//---------------------------------------------------------------------------------------------
function AfficherTab($tab)
{
    echo "<PRE>";
    print_r($tab);
    echo "</PRE>";
}
//---------------------------------------------------------------------------------------------
?>





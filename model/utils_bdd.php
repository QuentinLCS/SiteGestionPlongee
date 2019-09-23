<?php


// E.Porcq  pdo_oracle.php  11/10/2016

/*  Exemple
	$db_username = "ETU000";
	$db_password = "ETU000";
	//$db = "oci:dbname=info;charset=AL32UTF8"; // fonctionne si tnsname.ora est complet (base UTF8)
	//$db = "oci:dbname=info;charset=WE8ISO8859P15"; // fonctionne si tnsname.ora est complet
	$db = fabriquerChaineConnex(); // plus général (fonctionne toujours)

	$conn = ConnecterPDO($db,$db_username,$db_password);
*/

//---------------------------------------------------------------------------------------------
class maBDD extends PDO
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
    function LireDonneesPDO1($conn, $sql, &$tab)
    {
        $i = 0;
        foreach ($conn->query($sql, PDO::FETCH_ASSOC) as $ligne) // ici que ça se gère pour les lignes ou colonne
            $tab[$i++] = $ligne;
        $nbLignes = $i;
        return $nbLignes;
    }

    //---------------------------------------------------------------------------------------------
    function LireDonneesPDO2($conn, $sql, &$tab)
    {
        $i = 0;
        $cur = $conn->query($sql);
        while ($ligne = $cur->fetch(PDO::FETCH_ASSOC))
            $tab[$i++] = $ligne;
        $nbLignes = $i;
        return $nbLignes;
    }

    //---------------------------------------------------------------------------------------------
    function LireDonneesPDO3($conn, $sql, &$tab)
    {
        $cur = $conn->query($sql);
        $tab = $cur->fetchall(PDO::FETCH_ASSOC);
        return count($tab);
    }

    //---------------------------------------------------------------------------------------------
    function LireDonneesPDOPreparee($cur, &$tab)
    {
        $res = $cur->execute();
        $tab = $cur->fetchall(PDO::FETCH_ASSOC);
        return count($tab);
    }
}

//---------------------------------------------------------------------------------------------
// fonctions supplementaires
//---------------------------------------------------------------------------------------------
function fabriquerChaineConnexPDO()
{
    $hote = 'spartacus.iutc3.unicaen.fr';
    $port = '1521'; // port par défaut
    $service = 'info.iutc3.unicaen.fr';

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





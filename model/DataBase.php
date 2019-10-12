<?php

class DataBase extends PDO
{
    private $conn; // contiendra l'objet PDO

    public static $db;

    public function __construct($dsn, $username = null, $passwd = null, $options = null)
    {
        try {
            parent::__construct($dsn, $username, $passwd, $options);
        } catch (PDOException $e) {
            print_r($e);
        }

        $this->OuvrirConnexionPDO($dsn, $username, $passwd);
    }

    public function OuvrirConnexionPDO($db,$db_username,$db_password)
    {
        try
        {
            $this->conn = new PDO($db,$db_username,$db_password);
            $res = true;
        }
        catch (PDOException $erreur)
        {
            echo $erreur->getMessage();
        }
        return $res;
    }

    public function majDonnees($sql)
    {
        $res = $this->conn->exec($sql);

        return $res;
    }

    public function LireDonnees($sql, $entity = null)
    {
        $tab = [];
        $cur = $this->conn->query($sql);
        while ($ligne = $cur->fetch(PDO::FETCH_ASSOC))
            $tab[] = (is_null($entity) ? $ligne : new $entity($ligne));


        return $tab;
    }

    // -----
    public function preparerRequetePDO($sql)
    {
        $cur = $this->conn->prepare($sql);
        return $cur;
    }
    public function ajouterParamPDO($cur,$param,$contenu,$type='texte',$taille=0) // fonctionne avec preparerRequete
    {
        // Sur Oracle, on peut tout passer sans préciser le type. Sur MySQL ???
        //	if ($type == 'nombre')
        //		$cur->bindParam($param, $contenu, PDO::PARAM_INT);
        //	else
        //$cur->bindParam($param, $contenu, PDO::PARAM_STR, $taille);
        $cur->bindParam($param, $contenu);
        return $cur;
    }
    public function majDonneesPrepareesPDO($cur) // fonctionne avec ajouterParam
    {
        $res = $cur->execute();
        return $res;
    }
    public function majDonneesPrepareesTabPDO($cur,$tab) // fonctionne directement après preparerRequete
    {
        $res = $cur->execute($tab);
        return $res;
    }




    public function LireDonneesPDO1($sql,&$tab)
    {
        $i=0;
        foreach  ($this->conn->query($sql,PDO::FETCH_ASSOC) as $ligne)
            $tab[$i++] = $ligne;
        $nbLignes = $i;
        return $nbLignes;
    }

    public function LireDonneesPDO3($sql,&$tab)
    {
        $cur = $this->conn->query($sql);
        $tab = $cur->fetchall(PDO::FETCH_ASSOC);
        return count($tab);
    }
    public function LireDonneesPDOPreparee($cur)
    {
        $res = $cur->execute();
        $tab = $cur->fetchall(PDO::FETCH_ASSOC);
        return $tab;
    }
}


<?php
include_once('../model/utils/utils_bdd.php');

/*
$db_username = 'pphp2a16';
$db_password = 'Ohwie1shaeshohga';
$db_connect = 'mysql:host=localhost;dbname=pphp2a16_bd';
*/


$db_username = 'root';
$db_password = '';
$db_connect = 'mysql:host=localhost;dbname=projetphp';
//$db_connect = fabriquerChaineConnexPDO();


$db = new DataBase($db_connect ,$db_username, $db_password);
$dbIsConnected = $db->OuvrirConnexionPDO($db_connect, $db_username, $db_password);
echo '<meta charset="utf-8" />';
mb_internal_encoding("UTF-8");


    $title = 'Plongée | ';
    $pageRepertory = '../view/global/';
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        if (!file_exists('../controller/'. strtolower($page) . ".php")) $page = "Error_404";
        $title = $title . $page;
    } else {
        $page = 'home';
        $title = $title . 'Home';
    }
    ?>
    <html lang="fr">
        <head>
            <?php include_once($pageRepertory . 'head.html'); ?>
            <title><?php echo $title ?></title>
        </head>
        <body>
            <header>
                <?php include_once($pageRepertory . 'navbar.html'); ?>
            </header>
            <main>
                <?php include_once('../controller/' . strtolower($page) . '.php'); ?>
            </main>
            <footer class="page-footer white">
                <?php include_once($pageRepertory . 'footer.html'); ?>
            </footer>
            <script type="text/javascript" src="assets/js/main.js"></script>
        </body>
    </html>

    <?php
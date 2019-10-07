<?php
include_once('../utils/utils_bdd.php');


$db_username = 'pphp2a16';
$db_password = 'Ohwie1shaeshohga';
$db_connect = 'mysql:host=localhost;dbname=pphp2a16_bd';
//$db_connect = fabriquerChaineConnexPDO();

$db = new DataBase($db_connect ,$db_username, $db_password);
$dbIsConnected = $db->OuvrirConnexionPDO($db_connect, $db_username, $db_password);

    $title = 'Plongée | ';
    $pageRepertory = '../view/';
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
        <body>
        <head>
            <?php include_once($pageRepertory . 'head.html'); ?>
            <title><?php echo $title ?></title>
        </head>
        <header>
            <?php include_once($pageRepertory . 'navbar.php'); ?>
        </header>
        <main>
            <?php include_once('../controller/' . strtolower($page) . '.php'); ?>
        </main>
        <footer class="page-footer white z-depth-3">
            <?php include_once($pageRepertory . 'footer.html'); ?>
        </footer>
        <?php include_once($pageRepertory . 'javascripts.html'); ?>
        </body>
    </html>

    <?php
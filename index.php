<?php

/*
$db_username = 'pphp2a16';
$db_password = 'Ohwie1shaeshohga';
$db_connect = 'mysql:host=localhost;dbname=pphp2a16_bd';
*/

$db_username = 'root';
$db_password = '';
$db_connect = 'mysql:host=localhost;dbname=projetphp;charset=UTF8';

require_once('model/DataBase.php');
DataBase::$db = new DataBase($db_connect ,$db_username, $db_password);

require_once('controller/Router.php');
$router = new Router();

mb_internal_encoding("UTF-8");


    ?>

    <html lang="fr">
        <head>
            <?php include_once('view/global/head.html'); ?>
            <title>TITLE TEMPORAIRE</title>
            <meta charset="utf-8">
        </head>
        <body>
            <header>
                <?php include_once('view/global/navbar.html'); ?>
            </header>
            <main>
                <?php $router->routeRequest() ?>
            </main>
            <footer class="page-footer white">
                <?php include_once('view/global/footer.html'); ?>
            </footer>
            <script type="text/javascript" src="public/assets/js/main.js"></script>
        </body>
    </html>

    <?php
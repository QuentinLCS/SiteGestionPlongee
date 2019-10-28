<?php

define('URL', str_replace('index.php', '', (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']));


// BASE DE DONNEES DE L'IUT
/*
$db_username = 'pphp2a16';
$db_password = 'Ohwie1shaeshohga';
$db_connect = 'mysql:host=localhost;dbname=pphp2a16_bd';
*/

// BASE DE DONNEES LOCALE

$db_username = 'root';
$db_password = '';
$db_connect = 'mysql:host=localhost;dbname=projetphp;charset=UTF8';


require_once('model/DataBase.php');
DataBase::$db = new DataBase($db_connect ,$db_username, $db_password);

require_once('controller/_Router.php');

$router = new _Router();
$router->routeRequest();
mb_internal_encoding("UTF-8");

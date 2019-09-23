<?php
include_once("controller/Menu.php");
$title = "LeMangaFR | ";
$pageRepertory = "view/frontend/";
if (isset($_GET["page"])) {
    $page = $_GET["page"];
    if  (!file_exists($pageRepertory.strtolower($page).".php")) $page = "Error_404";
    $title = $title . $page;
} else {
    $page = "home";
    $title = $title . "Home";
}
?>
<html lang="fr">
<body>
<head>
    <?php include_once($pageRepertory."head.php"); ?>
    <title><?php echo $title ?></title>
</head>
<header>
    <?php include_once($pageRepertory."navbar.php"); ?>
</header>
<main>
    <?php include_once($pageRepertory.strtolower($page).".php"); ?>
</main>
<footer class="page-footer white z-depth-3">
    <?php include_once($pageRepertory."footer.php"); ?>
</footer>
</body>
</html>
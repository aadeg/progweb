<?php
require_once 'core/init.php';

$title = "Progettazione Web";
if (AuthManager::isAuthenticated())
    $title = "Benvenuto, " . AuthManager::currentOperator()->first_name;

?>

<?php require 'includes/base_start.php'; ?>

<header>
    <h1><?php echo $title; ?></h1>
</header>

<?php require 'includes/navbar.php' ?>

<?php require 'includes/base_end.php'; ?>
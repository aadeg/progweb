<?php
require_once '../core/init.php';

AuthManager::loginRequired();
$operator = AuthManager::currentOperator();

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <title><?php echo Template::getTitle(); ?></title>

    <meta name="author" content="Andrea Giove">
    <meta name="description" content="A simple tickets manager">

    <link rel='shortcut icon' type='image/x-icon' href='/static/imgs/favicon.ico'>

    <link rel="stylesheet" href="/static/css/common.css">
    <link rel="stylesheet" href="/static/css/form.css">
    <link rel="stylesheet" href="/static/css/effects.css">
    <link rel="stylesheet" href="/static/css/admin/dropdown.css">
    <link rel="stylesheet" href="/static/css/admin/style.css">
    <link rel="stylesheet" href="/static/css/admin/sidemenu.css">
    <?php echo Template::getStylesheetHTML(); ?>
</head>
<body>
    <header class="main-header">
        <img src="../static/imgs/logo_inv.png" alt="logo" class="logo">
        <h1 class="left">SimpleTicket</h1>
        <div class="dropdown right">
            <a href="#" onclick="dropdown(event);">
                <?php echo $operator->first_name . ' ' . $operator->last_name; ?> <i class="fa fa-caret-down"></i>
            </a>
            <ul id="operator-dropdown">
                <li><a href="/admin/profile.php">Profilo</a></li>
                <li><a href="/admin/logout.php">Logout</a></li>
            </ul>
        </div>
    </header>
    <aside>
        <?php require '../includes/admin/sidebar.php' ?>
    </aside>

    <main>

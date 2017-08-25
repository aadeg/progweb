<!DOCTYPE html>
<html lang="it">
    <head>
        <title><?php echo Template::getTitle(); ?></title>
        <meta charset="utf-8">

        <meta name="author" content="Andrea Giove">
        <meta name="description" content="A simple tickets manager">

        <link rel='shortcut icon' type='image/x-icon' href='/static/imgs/favicon.ico'>
        
        <link rel="stylesheet" href="static/css/common.css">
        <link rel="stylesheet" href="/static/css/form.css">
        <link rel="stylesheet" href="static/css/effects.css">
        <link rel="stylesheet" href="static/css/style.css">
        <?php echo Template::getStylesheetHTML(); ?>

    </head>
    <body>
        <header>
            <a href="/index.php"><h1>Machine Lab</h1></a>
            <a href="/admin/index.php" class="right"><img src="/static/imgs/lock.png" alt="admin" id="admin-icon"></a>
        </header>

        <div id="pweb-flag">
            <a href="/guide.html">Manuale utente</a>
        </div>

        <main>




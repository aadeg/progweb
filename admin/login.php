<?php 
require_once '../core/init.php';

use \View\AdminView;

$view = AdminView::login();
?>

<!DOCTYPE html>
<html lang="it">
    <head>
	<meta charset="utf-8">
	<title>SimpleTicket - Login</title>

	<meta name="author" content="Andrea Giove">
	<meta name="description" content="A simple tickets manager">
	
	<link rel="stylesheet" href="../static/css/admin/style.css">
	<link rel="stylesheet" href="../static/css/admin/login.css">
    </head>
    <body>
	<header>
	    <h1>SimpleTicket</h1>
	</header>

	<main>
	    <section class="panel">
		<header>
		    <h2>Pannello di controllo</h2>
		</header>

		<main>

		    <?php require "../includes/admin/flash_messages.php"; ?>

		    <form action="#" method="POST">
			<ul class="input-list">
			    <?php echo $view->form->as_li(); ?>
			</ul>
			<button type="submit">Login</button>
		    </form>
		</main>
	    </section>
	</main>
    </body>
</html>

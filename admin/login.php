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

	<link rel="stylesheet" href="../static/css/common.css">
	<link rel="stylesheet" href="../static/css/admin/style.css">
	<link rel="stylesheet" href="../static/css/effects.css">
	<link rel="stylesheet" href="../static/css/admin/login.css">

	<script src="../static/js/common.js"></script>
	<script src="../static/js/effects.js"></script>
    </head>
    <body>
	<!--
	<header>
	    <h1>SimpleTicket</h1>
	</header>
	-->

	<main>
	    <img src="#" alt="Logo">
	    <div id="login-box">
		<?php require "../includes/admin/flash_messages.php"; ?>
		<section class="panel fadeIn left">
		    <main>


			<form action="#" method="POST">
			    <ul class="input-list">
				<?php echo $view->form->as_li(); ?>
			    </ul>
			    <button type="submit" class="primary right">Login</button>
			</form>
		    </main>
		</section>
	    </div>
	</main>
    </body>
</html>

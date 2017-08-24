<?php 
require_once '../core/init.php';
Template::setTitle("Login");
use \View\AdminView;

$view = AdminView::login();
?>
<?php include '../includes/admin/base_login_start.php' ?>
<div class="main-box">
    <?php require "../includes/admin/flash_messages.php"; ?>
    <section class="panel fadeIn left">
	<div class="body">
	    <form action="#" method="POST">
		<ul class="input-list">
		    <?php echo $view->form->as_li(); ?>
		</ul>
		<button type="submit" class="primary right">Login</button>
	    </form>
	    <div class="clear"></div>
	</div>
	<footer>
	    <a href="/admin/password_recovery.php">Hai dimenticato la password?</a>
	</footer>
    </section>
</div>
<?php include '../includes/admin/base_login_end.php' ?>


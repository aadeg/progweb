<?php 
require_once '../core/init.php';
Template::setTitle("Cambia password");

use \View\RecoveryView;

$view = RecoveryView::recoveryChange();
?>
<?php include '../includes/admin/base_login_start.php' ?>
<div class="main-box">
    <?php require "../includes/admin/flash_messages.php"; ?>
    <section class="panel fadeIn left">
	<div class="body">
	    <p>Inserisca una nuova password di almeno 6 caratteri.</p>

	    <form action="#" method="POST">
		<ul class="input-list">
		    <?php echo $view->form->as_li(); ?>
		</ul>
		<button type="submit" class="primary right">Login</button>
	    </form>
	    <div class="clear"></div>
	</div>
    </section>
</div>
<?php include '../includes/admin/base_login_end.php' ?>


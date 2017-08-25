<?php
require_once ('../core/init.php');
Template::setTitle("Recupera password");

use \View\RecoveryView;

$view = RecoveryView::passwordRecovery();
?>

<?php include '../includes/admin/base_login_start.php' ?>
<div class="main-box">
    <?php require "../includes/admin/flash_messages.php"; ?>
    <section class="panel fadeIn left">
    <header>
        <h2>Recupera la password</h2>
    </header>
	<div class="body">
	    <p>Per recuperare la password, inserisca l'email con la quale si è registrato.</p>

	    <form action="#" method="POST">
		<ul class="input-list">
		    <?php echo $view->form->as_li(); ?>
		</ul>
		<button type="submit" class="primary right">Recupera</button>
	    </form>
	    <div class="clear"></div>
	</div>
    </section>
</div>
<?php include '../includes/admin/base_login_end.php' ?>


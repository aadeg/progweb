<?php
require_once 'core/init.php';

use \View\UserView;
$view = UserView::recoverTicket();

?>
<?php require 'includes/base_start.php'; ?>

<section class="panel fadeIn">
    <header>
	<h2>Recupara la tua pratica</h2>
    </header>
    
    <div class="body">
	<?php require "./includes/flash_messages.php"; ?>

	<p>Se non ricordi il tuo numero di pratica, compila i campi sottostani. Il numero di pratica sarà inviato alla tua email.</p>
	
	<form method="post" action="#">
	    <ul class="input-list">
		<?php echo $view->form->as_li(); ?>
	    </ul>
	    <button type="submit" class="right primary">Conferma</button>
	    <div style="clear: both;"></div>
	</form>
    </div>
</section>

<?php require 'includes/base_end.php'; ?>

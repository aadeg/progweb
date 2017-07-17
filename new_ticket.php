<?php
require_once 'core/init.php';

use \View\UserView;

$view = UserView::newTicket();

?>
<?php require 'includes/base_start.php'; ?>

<section class="panel" id="new-ticket-section">
    <header>
	<h2>Parla con un operatore</h2>
    </header>
    <main>
	<p>
	    Le chiediamo di inserire i propri dati anagrafici e di fornire una descrizione del suo problema, così da permettere ad un operatore di aiutarla.
	</p>
	
	<form method="post" action="#">
	    <ul class="input-list">
		<?php echo $view->form->as_li();  ?>
	    </ul>
	    <!-- <button type="submit">Invia</button> -->
	</form>
    </main>
</section>

<?php require 'includes/base_end.php'; ?>

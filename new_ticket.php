<?php
require_once 'core/init.php';

use \View\UserView;

$view = UserView::newTicket();

?>
<?php require 'includes/base_start.php'; ?>

<section class="panel fadeIn" id="new-ticket-section">
    <header>
	<h2>Contatta un operatore</h2>
    </header>
    <main>
	<!--
	<p>
	    Le chiediamo di inserire i propri dati anagrafici e di fornire una descrizione del suo problema, così da permettere ad un operatore di aiutarla.
	</p>
	-->
	
	<form method="post" action="#">
	    <!-- <ul class="input-list">
		<?php /* echo $view->form->as_li();  */?>
	    </ul>-->
	</form>
    </main>
    <footer>
	<button type="button" class="left" id="prev-step-btn">Indietro</button>
	<button type="button" class="right" id="next-step-btn">Avanti</button>
	<div style="clear: both;"></div>
    </footer>
</section>

<?php require 'includes/base_end.php'; ?>

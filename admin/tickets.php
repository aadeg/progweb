<?php
require_once '../core/init.php';
AuthManager::loginRequired();
Template::addStylesheet("../static/css/admin/tickets.css");
Template::addScript("../static/js/admin/TicketList.js");
Template::addScript("../static/js/admin/ticket.js");

use \View\AdminView;
$view = AdminView::tickets();
?>

<?php require '../includes/admin/base_start.php'; ?>

<h2>Ticket</h2>

<section class="panel ticket-list" id="ticket-list-new">
    <header>
	<h3><?php echo $view->title; ?></h3>
    </header>
    <div class="body">
	<form class="ticket-search" action="#">
	    <input type="text" id="search-bar" placeholder="Ricerca nella tabella">
	    <div id="only-checkbox-div">
		<label for="only-checkbox">Mostra solo i tuoi</label>
		<input id="only-checkbox" type="checkbox">
	    </div>
	</form>

	<table class="ticket-table">
	    <thead>
		<tr>
		    <th>ID</td>
		    <th>Oggetto</td>
		    <th>Cliente</td>
		    <th class="text-center">Categoria</td>
		    <th>Ultimo aggiornamento</td>
		</tr>
	    </thead>
	    <tbody>
	    </tbody>
	    <tfoot>
	    </tfoot>
	</table>
    </div>
</section>

<script>
 var operatorId = <?php echo AuthManager::currentOperator()->id; ?>
</script>

<?php require '../includes/admin/base_end.php'; ?>

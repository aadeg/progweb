<?php
require_once '../core/init.php';
AuthManager::loginRequired();
Template::addScript("../static/js/admin/TicketList.js");
Template::addScript("../static/js/admin/ticket.js");

?>

<?php require '../includes/admin/base_start.php'; ?>

<h2>Tickets</h2>

<section class="panel ticket-list" id="ticket-list-new">
    <header>
	<h3>Ticket non assegnati ad un operatore</h3>
    </header>
    <div class="body">
	<form class="ticket-search" action="#">
	    <input type="text" placeholder="Ricerca nella tabella">
	</form>

	<table class="ticket-table">
	    <thead>
		<tr>
		    <td>ID</td>
		    <td>Oggetto</td>
		    <td>Cliente</td>
		    <td class="text-center">Categoria</td>
		    <td class="text-center">Prorità</td>
		    <td>Ultimo aggiornamento</td>
		</tr>
	    </thead>
	    <tbody>
	    </tbody>
	</table>
    </div>
</section>

<?php require '../includes/admin/base_end.php'; ?>

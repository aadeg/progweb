<?php
require_once '../core/init.php';
AuthManager::loginRequired();
?>

<?php require '../includes/admin/base_start.php'; ?>

<h2>Tickets</h2>

<section class="ticket-list" id="ticket-list-new">
    <h3>Ticket non assegnati ad un operatore</h3>
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
</section>

<?php require '../includes/admin/base_end.php'; ?>

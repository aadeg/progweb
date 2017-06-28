<?php
require_once '../core/init.php';
AuthManager::loginRequired('/admin/index.php');
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
		<td width="7%">ID</td>
		<td width="40%">Oggetto</td>
		<td width="20%">Cliente</td>
		<td width="13%">Categoria</td>
		<td>Ultimo aggiornamento</td>
	    </tr>
	</thead>
	<tbody>
	    <tr><td>13</td><td>Oggetto di prova</td><td>Padoasodaosdoda</td><td>Guasti</td><td>30 minuti fa</td></tr>
	    <tr><td>13</td><td>Oggetto di prova</td><td>Padoasodaosdoda</td><td>Guasti</td><td>30 minuti fa</td></tr>
	    <tr><td>13</td><td>Oggetto di prova</td><td>Padoasodaosdoda</td><td>Guasti</td><td>30 minuti fa</td></tr>
	    <tr><td>13</td><td>Oggetto di prova</td><td>Padoasodaosdoda</td><td>Guasti</td><td>30 minuti fa</td></tr>
	    <tr><td>13</td><td>Oggetto di prova</td><td>Padoasodaosdoda</td><td>Guasti</td><td>30 minuti fa</td></tr>
	</tbody>
    </table>
</section>

<?php require '../includes/admin/base_end.php'; ?>

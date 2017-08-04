<?php
require_once '../core/init.php';
AuthManager::loginRequired();
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
	    <!-- <label>Mostra solo i tuoi</label>
	    <input type="checkbox">-->
		
	    <input type="text" placeholder="Ricerca nella tabella">
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

<?php require '../includes/admin/base_end.php'; ?>

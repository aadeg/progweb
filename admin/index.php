<?php
require_once '../core/init.php';
AuthManager::loginRequired();
Template::addStylesheet('../static/css/admin/dashboard.css');
Template::addScript('../static/js/admin/dashboard.js');

use \View\AdminView;
$view = AdminView::dashboard();

function ticketRow($t){
    $html = <<<EOD
<tr class="ticket-row" id="t-{$t->id}">
<td>{$t->id}</td>
<td>{$t->subject}</td>
<td>{$t->cust_first_name} {$t->cust_last_name}</td>
<td class="text-align">{$t->category}</td>
<td>{$t->last_activity}</td>
</tr>
EOD;
    return $html;
}
?>

<?php require '../includes/admin/base_start.php'; ?>


<h2>Dashboard</h2>

<section class="panel">
    <header>
	<h3>Contatori</h3>
    </header>
    <div class="body">
	<div class="counters">
	    <div class="counter">
		<p class="number"><?php echo $view->cNewTickets; ?></p>
		<p class="title">Ticket nuovi</p>
	    </div>
	    <div class="counter">
		<p class="number"><?php echo $view->cOwnPending; ?></p>
		<p class="title">I tuoi ticket in attesa</p>
	    </div>
	    <div class="counter">
		<!--<p class="number"><?php echo $view->cAllTickets; ?></p>-->
		<p class="number">138501</p>
		
		<p class="title">Tutti i ticket</p>
	    </div>
	</div>
    </div>
</section>

<section class="panel">
    <header>
	<h3>I tuoi ticket in attesa</h3>
    </header>
    <div class="body">
	<table class="ticket-table">
	    <thead>
		<tr>
		    <th>ID</th>
		    <th>Oggetto</th>
		    <th>Cliente</th>
		    <th class="text-center">Categoria</th>
		    <th>Ultimo aggiornamento</th>
		</tr>
	    </thead>
	    <tbody>
		<?php
		foreach($view->ownPending as $t) echo ticketRow($t);
		?>
	    </tbody>
	</table>
    </div>
</section>

<?php require '../includes/admin/base_end.php'; ?>

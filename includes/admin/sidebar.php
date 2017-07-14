<?php 
require_once dirname(__FILE__) . "/../../core/init.php";

$operator = AuthManager::currentOperator();
?>

<nav class="side-menu-nav">
<!--<div class="Operator-info">
	<p><?php echo $operator->first_name . ' ' . $operator->last_name; ?></p>
	<p class="small"><?php echo $operator->email; ?></p>
	<a class="#">Profilo</a>
    </div> -->

    <ul class="side-menu first-lvl">
	<li>
	    <a href="/admin/index.php">Dashboard</a>
	</li>
	<li>
	    <a href="#">Ticket</a>
	    <ul class="side-menu second-lvl collapsed">
		<li><a href="/admin/tickets.php?t=new">Nuovi</a>
		</li>
		<li><a href="/admin/tickets.php?t=open">Aperti</a></li>
	    </ul>
	</li>
	<li>
	    <a href="#">Amministrazione</a>
	</li>
    </ul>
</nav>

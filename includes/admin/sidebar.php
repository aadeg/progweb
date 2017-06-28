<?php 
require_once dirname(__FILE__) . "/../../core/init.php";

$operator = AuthManager::currentOperator();
?>

<nav>
    <p class="operator-info">
	<?php echo $operator->first_name . ' ' . $operator->last_name; ?>
    </p>

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
    </ul>
</nav>

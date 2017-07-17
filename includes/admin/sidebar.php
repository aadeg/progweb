<?php 
require_once dirname(__FILE__) . "/../../core/init.php";

AuthManager::loginRequired();
$operator = AuthManager::currentOperator();

function selMenu($index){
    // Confronta l'url della richiesta con l'espressione
    // regolare idetificata dall'indice per determinare se 
    // elemento della sidebar deve risultare selezionato
    // (.selected) oppure no

    $itemSelected = array(
	"0" => "/^\/admin\/(index\.php)?$/",
	"1" => "/^\/admin\/tickets\.php(\?)?/",
	"1-0" => "/^\/admin\/tickets\.php\?(.*)t=new/",
	"1-1" => "/^\/admin\/tickets\.php\?(.*)t=open/"
    );

    if (!isset($itemSelected[$index]))
	return "";

    $uri = $_SERVER['REQUEST_URI'];
    $pattern = $itemSelected[$index];
    if (preg_match($pattern, $uri))
	return "selected";
}

?>

<nav class="side-menu-nav">
<!--<div class="Operator-info">
	<p><?php echo $operator->first_name . ' ' . $operator->last_name; ?></p>
	<p class="small"><?php echo $operator->email; ?></p>
	<a class="#">Profilo</a>
    </div> -->

    <ul class="side-menu first-lvl">
	<li>
	    <a href="/admin/index.php" class="<?php echo selMenu("0"); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
	</li>
	<li>
	    <a href="#" class="<?php echo selMenu("1"); ?>"><i class="fa fa-list"></i>  Ticket</a>
	    <ul class="side-menu second-lvl collapsed">
		<li><a href="/admin/tickets.php?t=new" class="<?php echo selMenu("1-0"); ?>">Nuovi</a>
		</li>
		<li><a href="/admin/tickets.php?t=open" class="<?php echo selMenu("1-1"); ?>">Aperti</a></li>
	    </ul>
	</li>
	<li>
	    <a href="#" class="<?php echo selMenu("2"); ?>"><i class="fa fa-lock"></i> Amministrazione</a>
	</li>
    </ul>
</nav>

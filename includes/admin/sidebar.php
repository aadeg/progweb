<?php 
require_once dirname(__FILE__) . "/../../core/init.php";

AuthManager::loginRequired();
$operator = AuthManager::currentOperator();

$itemSelected = array(
    "0" => "/^\/admin\/(index\.php)?$/",
    "1" => "/^\/admin\/tickets\.php(\?)?/",
    "1-0" => "/^\/admin\/tickets\.php\?(.*)t=new/",
    "1-1" => "/^\/admin\/tickets\.php\?(.*)t=open/",
    "1-2" => "/^\/admin\/tickets\.php\?(.*)t=all/",
    "2" => "/^\/admin\/(add_operator|operators|ticket_categories)\.php/",
    "2-0" => "/^\/admin\/operators\.php/",
    "2-1" => "/^\/admin\/add_operator\.php/",
    "2-2" => "/^\/admin\/ticket_categories\.php/"
);

function selMenu($index){
    // Confronta l'url della richiesta con l'espressione
    // regolare idetificata dall'indice per determinare se 
    // elemento della sidebar deve risultare selezionato
    // (.selected) oppure no
    global $itemSelected;

    if (!isset($itemSelected[$index]))
	return "";

    $uri = $_SERVER['REQUEST_URI'];
    $pattern = $itemSelected[$index];
    if (preg_match($pattern, $uri))
	return "selected";
}

?>

<nav class="side-menu-nav">
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
		<li><a href="/admin/tickets.php?t=all" class="<?php echo selMenu("1-2"); ?>">Tutti</a>
	    </ul>
	</li>
	<?php if ($operator->is_admin) { ?>
	<li>
	    <a href="#" class="<?php echo selMenu("2"); ?>"><i class="fa fa-lock"></i> Amministrazione</a>
	    <ul class="side-menu second-lvl collapsed">
		<li><a href="/admin/operators.php" class="<?php echo selMenu("2-0"); ?>">Elenco operatori</a></li>
		<li><a href="/admin/add_operator.php" class="<?php echo selMenu("2-1"); ?>">Aggiungi operatore</a></li>
		<li><a href="/admin/ticket_categories.php" class="<?php echo selMenu("2-2"); ?>">Categorie ticket</a></li>
	    </ul>
	</li>
	<?php } ?>
    </ul>
</nav>

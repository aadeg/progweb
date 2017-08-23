<?php 
require_once dirname(__FILE__) . "/../../core/init.php";

AuthManager::loginRequired();
$operator = AuthManager::currentOperator();

$itemSelected = array(
    "0" => "/^\/admin\/(index\.php)?$/",
    "1" => "/^\/admin\/tickets\.php(\?)?/",
    "1-0" => "/^\/admin\/tickets\.php\?(.*)t=new/",
    "1-1" => "/^\/admin\/tickets\.php\?(.*)t=pending/",
    "1-2" => "/^\/admin\/tickets\.php\?(.*)t=open/",
    "1-3" => "/^\/admin\/tickets\.php\?(.*)t=all/",
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
	    <a href="/admin/index.php" class="<?php echo selMenu("0"); ?>">
		<img src="/static/imgs/dashboard.png" alt="dashboard" class="icon"> Dashboard
	    </a>
	</li>
	<li>
	    <a href="#" class="<?php echo selMenu("1"); ?>">
		<img src="/static/imgs/list.png" alt="list" class="icon"> Pratiche
	    </a>
	    <ul class="side-menu second-lvl collapsed">
		<li><a href="/admin/tickets.php?t=new" class="<?php echo selMenu("1-0"); ?>">Nuove</a>
		</li>
		<li><a href="/admin/tickets.php?t=pending" class="<?php echo selMenu("1-1"); ?>">In attesa</a></li>
		<li><a href="/admin/tickets.php?t=open" class="<?php echo selMenu("1-2"); ?>">Aperte</a></li>
		<li><a href="/admin/tickets.php?t=all" class="<?php echo selMenu("1-3"); ?>">Tutti</a>
	    </ul>
	</li>
	<?php if ($operator->is_admin) { ?>
	<li>
	    <a href="#" class="<?php echo selMenu("2"); ?>">
		<img src="/static/imgs/lock2.png" alt="lock" class="icon"></i> Amministrazione</a>
	    <ul class="side-menu second-lvl collapsed">
		<li><a href="/admin/operators.php" class="<?php echo selMenu("2-0"); ?>">Elenco operatori</a></li>
		<li><a href="/admin/add_operator.php" class="<?php echo selMenu("2-1"); ?>">Aggiungi operatore</a></li>
		<li><a href="/admin/ticket_categories.php" class="<?php echo selMenu("2-2"); ?>">Categorie ticket</a></li>
	    </ul>
	</li>
	<?php } ?>
    </ul>
</nav>

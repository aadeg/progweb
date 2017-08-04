<?php
require_once '../core/init.php';
AuthManager::loginRequired();
Template::addScript('../static/js/admin/operators.js');

use \View\AdminView;


$view = AdminView::operators();

function _operatorRow($op){
    $html = <<<EOD
<tr id="o-{$op->id}">
<td>{$op->id}</td>
<td>{$op->first_name} {$op->last_name}</td>
<td>{$op->username}</td>
<td>{$op->email}</td>
</tr>
EOD;
    return $html;
}
?>

<?php require '../includes/admin/base_start.php'; ?>

<h2>Eleco Operatori</h2>

<section class="panel">
    <header>
	<h3>Tutto gli operatori</h3>
    </header>

    <div class="body">
	<table>
	    <thead>
		<tr>
		    <th>ID</th>
		    <th>Nome e cognome</th>
		    <th>Username</th>
		    <th>Email</th>
		</tr>
	    </thead>
	    <tbody>
		<?php foreach($view->operators as $op){ ?>
		    <?php echo _operatorRow($op); ?>
		<?php } ?>
	    </tbody>
	</table>
    </div>
</section>

<?php require '../includes/admin/base_end.php'; ?>

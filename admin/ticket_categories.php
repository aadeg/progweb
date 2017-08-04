<?php
require_once '../core/init.php';
AuthManager::loginRequired();
AuthManager::adminRequired();

Template::addScript('../static/js/admin/ticket_categories.js');

use \View\AdminView;
$view = AdminView::ticketCategories();

function _categoryRow($cat){
    $html = <<<EOD
<tr id="c-{$cat->id}">
<td>{$cat->label}</td>
<td class='text-center'>{$cat->custom_fields}</td>
<td class='text-center'>{$cat->tickets}</td>
</tr>
EOD;
    return $html;
}
?>

<?php require '../includes/admin/base_start.php'; ?>

<h2>Elenco categorie</h2>

<section class="panel">
    <header>
	<h3>Categorie dei ticket</h3>
    </header>

    <div class="body">
	<table>
	    <thead>
		<tr>
		    <th>Etichetta</th>
		    <th class="text-center">Campi personalizzati</th>
		    <th class="text-center">Numero di ticket</th>
		</tr>
	    </thead>
	    <tbody>
		<?php foreach($view->categories as $cat){ ?>
		    <?php echo _categoryRow($cat); ?>
		<?php } ?>
	    </tbody>
	</table>
    </div>
</section>

<?php require '../includes/admin/base_end.php'; ?>

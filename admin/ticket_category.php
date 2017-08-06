<?php
require_once '../core/init.php';
AuthManager::loginRequired();
AuthManager::adminRequired();

Template::addStylesheet('../static/css/admin/ticket_category.css');
Template::addScript('../static/js/admin/CustomField.js');
Template::addScript('../static/js/admin/ticket_category.js');

use \View\AdminView;

$view = AdminView::ticketCategory();
?>

<?php require '../includes/admin/base_start.php'; ?>

<h2>Modifica categoria</h2>

<?php require '../includes/admin/flash_messages.php' ?>

<section class="panel">
    <header>
	<h3>Configurazioni categoria</h3>
    </header>

    <div class="body">
	<form action="#" method="post">
	    <ul class="input-list">
		<?php echo $view->categoryForm->as_li(); ?>
	    </ul>
	    <button type="submit" class="primary">Modifica</button>
	</form>
    </div>
</section>

<section class="panel">
    <header>
	<h3>Campi personalizzati</h3>
    </header>

    <div class="body">
    </div>

    <footer>
	<button type="button" id="btn-add-field">Aggiungi un nuovo campo</button>
    </footer>
</section>

<?php require '../includes/admin/base_end.php'; ?>

<?php
require_once '../core/init.php';
AuthManager::loginRequired();
AuthManager::adminRequired();
Template::setTitle("Aggiungi operatore");

use \View\AdminView;


$view = AdminView::addOperator();
?>

<?php require '../includes/admin/base_start.php'; ?>

<h2>Aggiungi operatore</h2>

<?php require "../includes/admin/flash_messages.php"; ?>

<section class="panel">
    <header>
        <h3>Modulo per la registrazione</h3>
    </header>

    <div class="body">
        <form method="post" action="#">
            <ul class="input-list">
                <?php echo $view->form->as_li(); ?>
            </ul>
            <button type="submit" class="primary">Aggiungi</button>
        </form>
    </div>
</section>

<?php require '../includes/admin/base_end.php'; ?>

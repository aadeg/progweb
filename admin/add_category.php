<?php
require_once '../core/init.php';
AuthManager::loginRequired();
AuthManager::adminRequired();

use \View\AdminView;

$view = AdminView::addCategory();
?>

<?php require '../includes/admin/base_start.php'; ?>

<h2>Aggiungi categoria</h2>

<?php require '../includes/admin/flash_messages.php' ?>

<section class="panel">
    <header>
        <h3>Nuova categoria</h3>
    </header>

    <div class="body">
        <form action="#" method="post">
            <ul class="input-list">
                <?php echo $view->form->as_li(); ?>
            </ul>
            <button type="submit" class="success">Aggiungi</button>
        </form>
    </div>
</section>

<?php require '../includes/admin/base_end.php'; ?>

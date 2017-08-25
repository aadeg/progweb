<?php
require_once '../core/init.php';
AuthManager::loginRequired();

use \View\AdminView;

$view = AdminView::profile();
Template::setTitle("Profilo {$view->operator->username}");
?>

<?php require '../includes/admin/base_start.php'; ?>

<h2><?php echo $view->title; ?></h2>

<?php require "../includes/admin/flash_messages.php"; ?>

<section class="panel">
    <header><h3>Informazioni personali</h3></header>
    <div class="body">
        <dl>
            <dt>Nome:</dt>
            <dd><?php echo $view->operator->first_name; ?></dd>
        </dl>
        <dl>
            <dt>Cognome:</dt>
            <dd><?php echo $view->operator->last_name; ?></dd>
        </dl>
        <dl>
            <dt>Email:</dt>
            <dd><?php echo $view->operator->email; ?></dd>
        </dl>
    </div>
</section>

<?php if ($view->ownProfile || $view->isAdmin){ ?>
<section class="panel">
    <header><h3>Cambia la password</h3></header>
    <div class="body">
        <p>Scegli una password di almeno 6 caratteri.</p>
        <form action="<?php echo $view->passwordFormAction; ?>" method="post">
            <ul class="input-list">
                <?php echo $view->passwordForm->as_li(); ?>
            </ul>
            <button type="submit" class="primary">Cambia password</button>
        </form>
    </div>
</section>
<?php } ?>

<?php if ($view->isAdmin){ ?>
<section class="panel">
    <header><h3>Amministrazione</h3></header>
    <div class="body">
        <form action="<?php echo $view->toggleFormAction; ?>" method="post">
            <button type="submit"><?php echo $view->toggleBtn; ?></button>
        </form>
    </div>
</section>
<?php } ?>

<?php require '../includes/admin/base_end.php'; ?>

<?php
require_once 'core/init.php';

use \View\UserView;
$view = UserView::checkTicket();
Template::setTitle("Visualizza pratica");

?>
<?php require 'includes/base_start.php'; ?>

<section class="panel fadeIn">
    <header>
        <h2>Visualizza la tua pratica</h2>
    </header>
    
    <div class="body">
        <?php require "./includes/flash_messages.php"; ?>
        <form method="post" action="#">
            <ul class="input-list">
                <?php echo $view->form->as_li(); ?>
            </ul>
            <button type="submit" class="right primary">Avanti</button>
            <div style="clear: both;"></div>
        </form>
    </div>
    <footer class="text-center">
        <a href="/recover_ticket.php">Non ricordi il numero di pratica?</a>
    </footer>
</section>

<?php require 'includes/base_end.php'; ?>

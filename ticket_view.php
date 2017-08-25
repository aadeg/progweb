<?php
require_once 'core/init.php';
Template::addStylesheet('/static/css/ticket_view.css');
Template::addScript('/static/js/Messages.js');
Template::addScript('/static/js/ticket_view.js');


use \View\UserView;
$view = UserView::ticketView();
Template::setTitle("Pratica #{$view->ticket->id}");

?>
<?php require 'includes/base_start.php'; ?>

<section class="panel" id="messages-box">
    <header>
        <h3>Oggetto: <?php echo $view->ticket->subject ?></h3>
    </header>

    <div class="body">
        <div class="messages">
            <ul class="message-list">
            </ul>
        </div>
    </div>
    <footer>
        <form action="#" method="post">
            <?php echo $view->form->html(false); ?>
            <button type="submit" class="right primary" <?php echo $view->btnDisabled; ?>>Invia messaggio</button>
        </form>
    </footer>
    <div class="clear"></div>
</section>

<?php require 'includes/base_end.php'; ?>


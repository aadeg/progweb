<?php
require_once 'core/init.php';
Template::addScript("./static/js/NewTicket.js");
Template::addScript("./static/js/new_ticket.js");
Template::setTitle("Nuova pratica");
?>
<?php require 'includes/base_start.php'; ?>

<section class="panel fadeIn" id="new-ticket-section">
    <header>
        <h2>Contatta un operatore</h2>
    </header>
    <div class="body">
        <form method="post" action="#">
        </form>
    </div>
    <footer>
        <button type="button" class="left" id="prev-step-btn">Indietro</button>
        <button type="button" class="right primary" id="next-step-btn">Avanti</button>
        <div style="clear: both;"></div>
    </footer>
</section>

<?php require 'includes/base_end.php'; ?>

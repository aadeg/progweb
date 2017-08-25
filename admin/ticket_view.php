<?php
require_once '../core/init.php';
AuthManager::loginRequired();
Template::addStylesheet('../static/css/admin/ticket_view.css');
Template::addScript('../static/js/admin/ticket_view.js');
Template::addScript('../static/js/Messages.js');
Template::addScript('../static/js/admin/TicketView.js');

use \View\AdminView;
use \Model\Message;

$operator = AuthManager::currentOperator();
$view = AdminView::ticketView();

Template::setTitle("Pratica #{$view->ticket->id}");

$optPriority = array("0" => "", "1" => "", "2" => "");
foreach ($optPriority as $key => &$value){
    if ($key == $view->ticket->priority){
        $value = "selected";
        break;
    }
}

?>

<?php require '../includes/admin/base_start.php'; ?>

<h2>Visualizzazione ticket</h2>
<section class="panel" id="messages-box">
    <header class="<?php echo $view->priorityClass; ?>">
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
            <textarea name="message" placeholder="Nuovo messaggio"></textarea>
            <button type="submit" class="right primary">Invia messaggio</button>
        </form>
    </footer>
</section>

<div id="side-box">
    <section class="panel">
        <header>
            <h4>Info</h4>
        </header>
        <div class="body">
            <dl>
                <dt>Cliente:</dt>
                <dd><?php echo $view->customerFullName; ?></dd>
            </dl>
            <dl>
                <dt>Email:</dt>
                <dd><?php echo $view->ticket->cust_email; ?></dd>
            </dl>
            <dl>
                <dt>Aperto il:</dt>
                <dd><?php echo $view->openAtStr; ?></dd>
            </dl>
        </div>
    </section>

    <section class="panel">
        <header>
            <h4>Azioni</h4>
        </header>
        <div class="body">
            <form method="post" action="#">
                <ul class="input-list">
                    <li>
                        <label>Priorità:</label>
                        <select class="small" id="priority-select">
                            <option value="0" <?php echo $optPriority["0"]; ?>>Bassa</option>
                            <option value="1" <?php echo $optPriority["1"]; ?>>Normale</option>
                            <option value="2" <?php echo $optPriority["2"]; ?>>Alta</option>
                        </select>
                    </li>
                    <li>
                        <label>Sposta in:</label>
                        <select class="small" id="category-select">
                            <?php
                            $ticket = &$view->ticket;
                            foreach ($view->categories as $cat){
                                $selected = "";
                                if ($cat->id == $ticket->category)
                                    $selected = "selected";
                                echo "<option value={$cat->id} $selected>";
                                echo $cat->label;
                                echo "</option>";
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <label>Assegna a:</label>
                        <select class="small" id="assign-select">
                            <option value="0" <?php if(!$view->ticket->operator) echo "selected"; ?>>---</option>
                            <?php
                            $ticket = &$view->ticket;
                            foreach ($view->operators as $op){
                                $selected = "";
                                if ($op->id == $ticket->operator)
                                    $selected = "selected";
                                echo "<option value='{$op->id}' $selected>";
                                echo "{$op->first_name} {$op->last_name}";
                                echo "</option>";
                            }
                            ?>
                        </select>
                    </li>

                    <li>
                        <button class="small" type="button" id="close-button">Chiudi ticket</button>
                    </li>
                    <li>
                        <button class="small" type="button" id="delete-button">Rimuovi ticket</button>
                    </li>
                </ul>
            </form>
        </div>
    </section>
</div>
<script>
 var operatorId = <?php echo $operator->id; ?>;
</script>
<?php require '../includes/admin/base_end.php'; ?>

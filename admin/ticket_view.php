<?php
require_once '../core/init.php';
AuthManager::loginRequired();
Template::addStylesheet('../static/css/admin/ticket_view.css');

use \View\AdminView;

function getMessageElement($msg){
    $msgClass = strtolower($msg->type);
    $html = "<li class='message {$msgClass}'>";
    $html .= "<div class='message-text'>";
    $html .= $msg->text;
    $html .= "</div>";
    $html .= "</li>";
    return $html;
}
$view = AdminView::ticketView();
?>

<?php require '../includes/admin/base_start.php'; ?>

<h2>Visualizzazione ticket</h2>
<section class="panel" id="messages-box">
    <header>
	<h3>Oggetto: <?php echo $view->ticket->subject ?></h3>
    </header>

    <main>
	<section class="messages">
	    <ul class="message-list">
		<?php
		foreach($view->messages as $msg) {
		    echo getMessageElement($msg);
		}
		?>
	    </ul>
	</section>
    </main>
</section>

<div id="side-box">
    <section class="panel">
	<header>
	    <h4>Info</h4>
	</header>
	<main>
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
	</main>
    </section>

    <section class="panel">
	<header>
	    <h4>Azioni</h4>
	</header>
	<main>
	    <form method="post" action="#">
		<label>Assegna a:</label>
		<select class="small">
		    <option value="0">Bla</option>
		</select>
		<button type="button" class="small">Assegna</button>
	    </form>

	    
	    <button class="small">Chiudi</button>
	    <button class="small">Rimuovi</button>
	</main>
    </section>
</div>

<?php require '../includes/admin/base_end.php'; ?>

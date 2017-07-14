<?php
require_once '../core/init.php';
AuthManager::loginRequired();

$ticketId = Input::get('id');
if (!$ticketId)
    Redirect::error(404);
?>

<?php require '../includes/admin/base_start.php'; ?>

<h2>Ticket #<?php echo $ticketId ?></h2>
<section>
    <h3>Oggetto: </h3>

    <dl>
	<dt>Cliente:</dt>
	<dd>Nome Cognome</dd>
    </dl>
    <dl>
	<dt>Email:</dt>
	<dd>prova@prova.it</dd>
    </dl>
    <dl>
	<dt>Apertura ticket:</dt>
	<dd>14/07/2017 10:44</dd>
    </dl>

    <section class="actions">
	<p>Azioni (chiudi, assegna, rimuovi)</p>
    </section>

    <section class="messages">
	<p>Messaggi</p>
    </section>
</section>

<?php require '../includes/admin/base_end.php'; ?>

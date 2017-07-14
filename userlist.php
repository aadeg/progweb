<?php
require_once 'core/init.php';

use \Model\Operator;

AuthManager::loginRequired();       // Protezione alla pagina

$operators = Operator::getAll()->rows();

?>

<?php require 'includes/base_start.php'; ?>

<?php require 'includes/navbar.php' ?>

<main>
    <section>
        <h2>Utenti registrati</h2>
        <pre><?php print_r($operators); ?></pre>
    </section>
</main>

<?php require 'includes/base_end.php'; ?>
<?php
require_once 'core/init.php';

use \Model\User;

AuthManager::loginRequired();       // Protezione alla pagina

$users = User::getAll()->rows();

?>

<?php require 'includes/base_start.php'; ?>

<main>
    <section>
        <h2>Utenti registrati</h2>
        <pre><?php print_r($users); ?></pre>
    </section>
</main>

<?php require 'includes/base_end.php'; ?>
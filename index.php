<?php
require_once 'core/init.php';

use \Model\User;

$users = User::getAll();

if ($users->error()){
    die($users->errorMsg());
}

$title = ($isAuthenticated) ? "Benvenuto, {$currentUser->name}" : "Progettazione Web";
$users = User::getAll()->rows();

?>

<?php require 'includes/base_start.php'; ?>

<header>
    <h1><?php echo $title ?></h1>
</header>

<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <?php if(!$isAuthenticated){ ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php } else { ?>
            <li><a href="logout.php">Logout</a></li>
        <?php } ?>
    </ul>   
</nav>

<main>
    <section>
        <h2>Utenti registrati</h2>
        <pre><?php print_r($users); ?></pre>
    </section>
</main>

<?php require 'includes/base_end.php'; ?>
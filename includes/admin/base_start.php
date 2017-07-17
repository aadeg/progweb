<?php 
AuthManager::loginRequired();
$operator = AuthManager::currentOperator();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <title>SimpleTicket</title>

    <meta name="author" content="Andrea Giove">
    <meta name="description" content="A simple tickets manager">

    <link rel="stylesheet" href="../static/css/font-awesome.min.css">
    <link rel="stylesheet" href="../static/css/common.css">
    <link rel="stylesheet" href="../static/css/admin/style.css">
    <link rel="stylesheet" href="../static/css/admin/sidemenu.css">

    <script src="../static/js/common.js"></script>
    <script src="../static/js/admin/sidemenu.js"></script>
    <script src="../static/js/admin/TicketList.js"></script>
    <script src="../static/js/admin/ticket.js"></script>
</head>
<body>
      <header>
	  <h1 class="left">SimpleTicket</h1>
	  <a href="#" class="right"><?php echo $operator->first_name . ' ' . $operator->last_name; ?></a>
      </header>

      <aside>
	  <?php require '../includes/admin/sidebar.php' ?>
      </aside>

      <main>

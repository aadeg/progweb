<?php 
require_once '../core/init.php';

use \Ajax\AjaxNewTicket;
$handler = new AjaxNewTicket();
$handler->handleRequest();
?>

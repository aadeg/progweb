<?php 
require_once '../../core/init.php';

use \Ajax\AjaxTicket;
$handler = new AjaxTicket();
$handler->handleRequest();
?>

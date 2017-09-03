<?php 
require_once '../core/init.php';

use \Ajax\AjaxTicketCategory;
$handler = new AjaxTicketCategory(true);
$handler->handleRequest();
?>

<?php 
require_once '../../core/init.php';

use \Ajax\AjaxMessage;
$handler = new AjaxMessage(false);
$handler->handleRequest();
?>

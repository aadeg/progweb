<?php 
require_once '../core/init.php';

use \Ajax\AjaxCustomField;
$handler = new AjaxCustomField(true);
$handler->handleRequest();
?>

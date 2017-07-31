<?php
require_once dirname(__FILE__) . '/../core/init.php';


$msgs = Session::flashMessages();

foreach ($msgs as $msg){
    echo "<div class='alert " . $msg["level"] . "'>";
    echo $msg['msg'];
    echo "</div>";
}

?>

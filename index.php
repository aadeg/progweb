<?php
require_once 'core/init.php';

use \Model\User;

$users = User::getAll($db);

if ($users->error()){
    die($users->errorMsg());
}

echo "<pre>";
var_dump($users->rows());
echo "</pre>";

echo Session::get(Config::get('session.session_name'));
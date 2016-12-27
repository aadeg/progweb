<?php
session_start();

require_once './core/config.php';

spl_autoload_register(function($class) {
	$class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
	require_once 'classes/' . $class . '.php';
});

// Database
$host = Config::get('mysql.host');
$username = Config::get('mysql.username');
$password = Config::get('mysql.password');
$dbname = Config::get('mysql.db');
$db = new Database\DB($host, $username, $password, $dbname);

// MODELS
Model\Operator::setDatabase($db);
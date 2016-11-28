<?php
session_start();

$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => 'andrea',
		'db' => 'progweb'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
	),
	'session' => array(
		'session_name' => 'user'
	)
);

spl_autoload_register(function($class) {
	$class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
	require_once 'classes/' . $class . '.php';
});

// DATABASE
$host = Config::get('mysql.host');
$username = Config::get('mysql.username');
$password = Config::get('mysql.password');
$dbname = Config::get('mysql.db');
$db = new DB($host, $username, $password, $dbname);
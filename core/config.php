
<?php
$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'db' => 'progweb'
    ),
    'authmanager' => array(
        'login_page' => '/admin/login.php',
        'index_page' => 'index.php'
    ),
    'session' => array(
        'session_name' => 'user',
	'flash_messages' => 'flash'
    ),
    'error_page' => array(
	404 => '/404.php'
    ),
    'email' => array(
	'host' => 'smtp.gmail.com',
	'smtp_auth' => true,
	'username' => 'pweb1617@gmail.com',
	'password' => 'andrea96',
	'smtp_secure' => 'tls',
	'port' => 587,
	'default_from' => 'pweb1617@gmail.com',
	'default_name' => 'SimpleTicket'
    )
);

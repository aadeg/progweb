
<?php
$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => 'andrea',
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
    )
);

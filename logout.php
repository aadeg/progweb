<?php

require_once 'core/init.php';

use \Model\User;

User::logout();
Redirect::to('index.php');
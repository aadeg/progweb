<?php

require_once 'core/init.php';

AuthManager::logout();
Redirect::to('index.php');
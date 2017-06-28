<?php
require_once '../core/init.php';
AuthManager::loginRequired('/admin/index.php');
?>

<?php require '../includes/admin/base_start.php'; ?>

<h2>Dashboard</h2>

<?php require '../includes/admin/base_end.php'; ?>

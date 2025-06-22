<?php
session_start();
require_once 'config.php';
require_once 'controllers/TimelineController.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$controller = new TimelineController($pdo);
$controller->admin();
?>
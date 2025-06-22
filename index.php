<?php
require_once 'config.php';
require_once 'controllers/TimelineController.php';

$controller = new TimelineController($pdo);
$controller->index();
?>
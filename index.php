<?php
// index.php
require_once __DIR__ . '/controllers/TokenController.php';

$controller = new TokenController();
$controller->handleRequest();
?>

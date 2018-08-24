<?php
$stack = require_once __DIR__ . '/../config/bootstrap.php';

use Zend\Diactoros\Server;

$server = Server::createServer(
    [$stack, 'handle'],
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES);

$server->listen();
<?php
$stack = require_once __DIR__ . '/../config/bootstrap.php';

use Zend\Diactoros\Server;

/*
 |-------------------
 | Application Server
 |-------------------
 | Configures a Zend HTTP Application server. This object
 | will create a request from the context and feed it to
 | our application stack.
 */
$server = Server::createServer(
    [$stack, 'handle'],
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$server->listen();
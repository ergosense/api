<?php
$stack = require_once __DIR__ . '/../config/bootstrap.php';

$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();

$response = $stack->handle($request);

$emitter = new \Ergosense\Emitter\Emitter;

$emitter->emit($response);
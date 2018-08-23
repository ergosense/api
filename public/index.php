<?php
require_once __DIR__ . '/../vendor/autoload.php';

$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();

$kernel = new \OAF\Kernel([
    __DIR__ . '/../config/services.php',
    __DIR__ . '/../config/default.php'
]);

$res = $kernel->handle($request);
$kernel->emit($res);
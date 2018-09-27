<?php
$stack = require_once __DIR__ . '/../di/bootstrap.php';

use Zend\HttpHandlerRunner\RequestHandlerRunner;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
/*
 |-------------------
 | Application Server
 |-------------------
 | Configures a Zend HTTP Application server. This object
 | will create a request from the context and feed it to
 | our application stack.
 */
 $runner = new RequestHandlerRunner(
    $stack,
    new SapiEmitter,
    [ServerRequestFactory::class, 'fromGlobals'],
    function () {
        return null;
    }
);

$runner->run();
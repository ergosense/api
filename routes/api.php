<?php
use Ergosense\Action\PostLogin;
use Ergosense\Action\GetMe;

use Ergosense\Middleware\JwtAuth;

$r->get('/v1/me', [ JwtAuth::class, GetMe::class ]);
$r->post('/v1/login', PostLogin::class);

$r->get('/users', function () {});
$r->post('/users', function () {});
$r->get('/users/{id}', function () {});

$r->get('/company', function ($request) {

});

$r->get('/company/{id}', function ($request) {

});
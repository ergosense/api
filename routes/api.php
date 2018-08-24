<?php
use Ergosense\Action\Login;
use Ergosense\Action\GetMe;

$r->get('/v1/me', GetMe::class);
$r->post('/v1/login', Login::class);

$r->get('/users', function () {});
$r->post('/users', function () {});
$r->get('/users/{id}', function () {});

$r->get('/company', function ($request) {

});

$r->get('/company/{id}', function ($request) {

});
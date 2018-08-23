<?php
$r->addGroup('/v1', function ($r) {
    $r->get('/me', \Ergosense\Action\Me::class);

    $r->post('/login', \Ergosense\Action\Login::class);

    $r->get('/company', function ($request) {

    });

    $r->get('/company/{id}', function ($request) {

    });
});


$r->addRoute('GET', '/', \Ergosense\Action\Host::class);
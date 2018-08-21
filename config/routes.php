<?php
use Ergosense\Middleware\ContentTypeMiddleware;
use Ergosense\Middleware\AuthMiddleware;

$v1 = $app->group('/v1', function () {
  $this->post('/tokens', \Ergosense\Action\CreateToken::Class);

  $authedRoutes = $this->group('', function () {
    $this->get('/me', \Ergosense\Action\Me::class);
    $this->get('/company/{id}', \Ergosense\Action\Company\Get::class);
  });

  $authedRoutes->add(AuthMiddleware::class);
});

$v1->add(ContentTypeMiddleware::class);
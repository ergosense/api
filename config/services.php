<?php
$c = $app->getContainer();

/**
 * Content serializer. Responsible for handling the "Accept"
 * header specified by the end user.
 */
use Ergosense\Serializer\Serializer;
use Ergosense\Serializer\JsonDataSerializer;

$c[Serializer::class] = function ($c) {
    $serializer = new Serializer();

    // Register the allowed output serializers
    $serializer->register(new JsonDataSerializer());
    return $serializer;
};

/**
 * Content Type middleware. Validates that we can decode
 * a users request into a usable format as well as serialize it into
 * an acceptable output.
 */
use Ergosense\Middleware\ContentTypeMiddleware;

$c[ContentTypeMiddleware::class] = function ($c) {
    return new ContentTypeMiddleware($c[Serializer::class]);
};

/**
 * Authentication. Ensures user has access to our system
 * and populates the route with the ID of the user requesting the
 * resource.
 */
use Ergosense\Middleware\AuthMiddleware;
use Ergosense\Auth\JsonWebToken;

$c[AuthMiddleware::class] = function ($c) {
    $auth = new AuthMiddleware();

    // Register the allowed authentication methods
    $auth->register(new JsonWebToken($c['settings']['jwt_key']));
    return $auth;
};

/**
 * Database connection
 */
$c['db'] = function ($c) {
  $driver     = $c['settings']['pdo']['driver'];
  $host       = $c['settings']['pdo']['host'];
  $db         = $c['settings']['pdo']['db'];
  $user       = $c['settings']['pdo']['user'];
  $password   = $c['settings']['pdo']['password'];
  $connection = sprintf('%s:host=%s;dbname=%s', $driver, $host, $db);

  return new \Aura\Sql\ExtendedPdo($connection, $user, $password);
};

$c[\Ergosense\Action\Company\Get::class] = function ($c) {
  return new \Ergosense\Action\Company\Get($c[\Ergosense\Repository\CompanyRepository::class]);
};

$c[\Ergosense\Action\Company\Search::class] = function ($c) {
  return new \Ergosense\Action\Company\Search($c[\Ergosense\Repository\CompanyRepository::class]);
};

$c['oaf.auth'] = function ($c) {
  return new \OAF\AuthStack;
};

$c[\Ergosense\Action\CreateToken::class] = function ($c) {
  return new \Ergosense\Action\CreateToken($c[\Ergosense\Repository\UserRepository::class], $c['settings']['jwt_key']);
};

$c[\Ergosense\Action\Me::class] = function ($c) {
  return new \Ergosense\Action\Me($c[\Ergosense\Repository\UserRepository::class]);
};

$c[\Ergosense\Repository\UserRepository::class] = function ($c) {
  return new \Ergosense\Repository\UserRepository($c['db'], $c['query.factory']);
};

$c[\Ergosense\Repository\CompanyRepository::class] = function ($c) {
  return new \Ergosense\Repository\CompanyRepository($c['db'], $c['query.factory']);
};

$c['query.factory'] = function ($c) {
  return new \Aura\SqlQuery\QueryFactory($c['settings']['pdo']['driver']);
};
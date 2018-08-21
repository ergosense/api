<?php
use Psr\Container\ContainerInterface;
use Ergosense\Serializer\Serializer;
use Ergosense\Serializer\JsonDataSerializer;
use Ergosense\Middleware\ContentTypeMiddleware;
use Ergosense\Middleware\AuthMiddleware;
use Ergosense\Auth\JsonWebToken;
use Aura\Sql\ExtendedPdo;
use Aura\SqlQuery\QueryFactory;
use Ergosense\Error\ErrorHandler;

return [
    /**
     * Content serializer. Responsible for handling the "Accept"
     * header specified by the end user.
     */
    Serializer::class => function (ContainerInterface $c) {
        $serializer = new Serializer();

        // Register the allowed output serializers
        $serializer->register(new JsonDataSerializer());
        return $serializer;
    },
    /**
     * Authentication. Ensures user has access to our system
     * and populates the route with the ID of the user requesting the
     * resource.
     */
    AuthMiddleware::class => function (ContainerInterface $c) {
        $auth = new AuthMiddleware();

        // Register the allowed authentication methods
        $auth->register(new JsonWebToken($c->get('settings')['jwt_key']));
        return $auth;
    },
    /**
     * Database connection details. We use PDO by default
     * decorated by the Aura.Sql library for better connection
     * management.
     */
    PDO::class => function (ContainerInterface $c) {
        $settings   = $c->get('settings');
        $driver     = $settings['pdo']['driver'];
        $host       = $settings['pdo']['host'];
        $db         = $settings['pdo']['db'];
        $user       = $settings['pdo']['user'];
        $password   = $settings['pdo']['password'];
        $connection = sprintf('%s:host=%s;dbname=%s', $driver, $host, $db);

        return new ExtendedPdo($connection, $user, $password);
    },
    QueryFactory::class => function (ContainerInterface $c) {
        return new QueryFactory($c->get('settings')['pdo']['driver']);
    },
    /**
     * Overwrite the default Slim error handler
     */
    'errorHandler' => function (ContainerInterface $c) {
        return new ErrorHandler($c->get(Serializer::class));
    }
];
<?php
use Psr\Container\ContainerInterface;
use Aura\Sql\ExtendedPdo;
use Aura\SqlQuery\QueryFactory;

use Tuupola\Middleware\JwtAuthentication;

// controllers, to be removed later
use function DI\autowire;
use function DI\get;

return [
    /**
     * Database connection details. We use PDO by default
     * decorated by the Aura.Sql library for better connection
     * management.
     */
    PDO::class => function (ContainerInterface $c) {
        $driver     = $c->get('pdo.driver');
        $host       = $c->get('pdo.host');
        $db         = $c->get('pdo.db');
        $user       = $c->get('pdo.user');
        $password   = $c->get('pdo.password');
        $connection = sprintf('%s:host=%s;dbname=%s', $driver, $host, $db);

        return new ExtendedPdo($connection, $user, $password);
    },
    QueryFactory::class => function (ContainerInterface $c) {
        return new QueryFactory($c->get('pdo.driver'));
    },
    JwtAuthentication::class => function (ContainerInterface $c) {
        return new JwtAuthentication([
            'secret'    => $c->get('jwt_key')
        ]);
    },
    Ergosense\Service\JwtIssuer::class => function (ContainerInterface $c) {
        return new \Ergosense\Service\JwtIssuer('http://ergosense.io', $c->get('jwt_key'));
    },
    Ergosense\Action\Login::class => DI\autowire()
        ->constructorParameter('secret', DI\get('jwt_key'))
];
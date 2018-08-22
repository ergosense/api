<?php
use Psr\Container\ContainerInterface;
use OAF\Encoder\Encoder;
use Aura\Sql\ExtendedPdo;
use Aura\SqlQuery\QueryFactory;
use Ergosense\Error\ErrorHandler;

// controllers, to be removed later
use function DI\autowire;
use function DI\get;
use Ergosense\Action\Login;

return [
    /**
     * Database connection details. We use PDO by default
     * decorated by the Aura.Sql library for better connection
     * management.
     */
    PDO::class => function (ContainerInterface $c) {
        $driver     = $c->get('settings.pdo.driver');
        $host       = $c->get('settings.pdo.host');
        $db         = $c->get('settings.pdo.db');
        $user       = $c->get('settings.pdo.user');
        $password   = $c->get('settings.pdo.password');
        $connection = sprintf('%s:host=%s;dbname=%s', $driver, $host, $db);

        return new ExtendedPdo($connection, $user, $password);
    },
    QueryFactory::class => function (ContainerInterface $c) {
        return new QueryFactory($c->get('settings.pdo.driver'));
    },
    // TODO fix this, we don't want to register controllers
    Login::class => autowire()
        ->constructorParameter('secret', get('settings.jwt_key')),
];
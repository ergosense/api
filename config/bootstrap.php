<?php
require_once __DIR__ . '/../vendor/autoload.php';

use DI\ContainerBuilder;

// Build the default framework container
$builder = new ContainerBuilder;

// Default framework services
$builder->addDefinitions(__DIR__ . '/../config/services_core.php');
$builder->addDefinitions(__DIR__ . '/../config/services.php');
$builder->addDefinitions(__DIR__ . '/../config/default.php');

// Construct the container
$container = $builder->build();

$stack = new \Ergosense\Stack;

$stack
    // Routing
    ->with(new \Middlewares\JsonPayload)
    ->with(new \Ergosense\Middlewares\FastRoute($container->get(\FastRoute\Dispatcher::class), $container->get(\Ergosense\RouteLoader\RouteLoaderInterface::class)))
    ->with(new \Ergosense\Middlewares\RequestHandler(new \Ergosense\CallableResolver($container)));

return $stack;
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


use Zend\Stratigility\MiddlewarePipe;

$stack = new MiddlewarePipe();

// Error Handling
$stack->pipe(new \Ergosense\Middlewares\ErrorHandler);

// Header: Content-Type
$stack->pipe(new \Ergosense\Middlewares\ContentType($container->get(\Ergosense\Encoder\ResponseEncoderInterface::class)));

// Header: Accepted
$stack->pipe(new \Middlewares\JsonPayload);

// Routing
$stack->pipe(new \Ergosense\Middlewares\FastRoute($container->get(\FastRoute\Dispatcher::class), $container->get(\Ergosense\RouteLoader\RouteLoaderInterface::class)));

$stack->pipe(new \Ergosense\Middlewares\RequestHandler(new \Ergosense\CallableResolver($container)));

return $stack;
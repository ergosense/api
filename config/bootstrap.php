<?php
require_once __DIR__ . '/../vendor/autoload.php';

use FastRoute\RouteCollector;
use DI\ContainerBuilder;
use Zend\Stratigility\MiddlewarePipe;
use OAF\Middleware\ErrorHandler;
use OAF\Middleware\ContentType;
use Middlewares\JsonPayload;
use OAF\Middleware\JwtAuth;
use OAF\Middleware\RequestHandler;

/*
 |---------------------
 | Dependency Injection
 |---------------------
 | The dependency injection container can be any
 | container that implements PSR 11.
 |
 | @see https://en.wikipedia.org/wiki/Dependency_injection
 */
$builder = new ContainerBuilder;

$builder->addDefinitions(__DIR__ . '/../vendor/ergosense/php-oaf/config/services.php');
$builder->addDefinitions(__DIR__ . '/services.php');
$builder->addDefinitions(__DIR__ . '/param_default.php');

$container = $builder->build();

/*
 |----------------
 | Request Routing
 |----------------
 | The application routing defines the mapping
 | between URLs and executable functions. Our
 | implementation uses @see https://github.com/nikic/FastRoute
 */
$r = $container->get(RouteCollector::class);
require_once __DIR__ . '/../routes/api.php';

/*
 |------------------
 | Application Stack
 |------------------
 | This application uses a PSR 15 framework
 | that relies on a series of middleware callbacks
 | that execute on a given request.
 |
 | @see https://www.php-fig.org/psr/psr-15/
 */
$stack = new MiddlewarePipe();

$stack->pipe($container->get(ErrorHandler::class));
$stack->pipe($container->get(ContentType::class));
$stack->pipe($container->get(JsonPayload::class));
$stack->pipe($container->get(JwtAuth::class));
$stack->pipe($container->get(RequestHandler::class));

return $stack;
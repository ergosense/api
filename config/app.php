<?php
require_once __DIR__ . '/../vendor/autoload.php';

use DI\ContainerBuilder;
use Slim\App;

// Build a new container. We won't make use of the PHP-DI bridge as it
// changes default Slim functionality. Since we want the features PHP-DI provides
// we need to build the container and it's settings manually.
$containerBuilder = new ContainerBuilder;

// We want auto wiring, but annotations cluters up the
// doc comments and is less implicit than type hints
$containerBuilder->useAutowiring(true);
$containerBuilder->useAnnotations(false);

// Register config/service files
$containerBuilder->addDefinitions(__DIR__ . '/slim_services.php');
$containerBuilder->addDefinitions(__DIR__ . '/services.php');
$containerBuilder->addDefinitions(__DIR__ . '/vars_development.php');

// Contstruct the container object and pass it to the app
$container = $containerBuilder->build();

// Start the slip application
$app = new App($container);

// Define the routes
require_once __DIR__ . '/routes.php';

return $app;
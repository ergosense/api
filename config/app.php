<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Slim\App;

$app = new App(require_once(__DIR__ . '/vars_development.php'));

// Routes
require_once __DIR__ . '/routes.php';

// Extend service container
require_once __DIR__ . '/services.php';

return $app;
<?php
/**
 * DO NOT EDIT: Instead override the values in a different
 * service file.
 *
 * TODO move into composer package
 *
 * Please look at DefaultServicesProvider.php in the Slim
 * repository. We are essentially copying that class here.
 * We would use that class, but the PSR-11 doesn't define array-like
 * access which the pimple DI uses. PHP-DI uses array PHP definitions
 * like used here.
 */
use Psr\Container\ContainerInterface;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Http\Environment;
use Slim\Handlers\PhpError;
use Slim\Handlers\Error;
use Slim\Handlers\NotFound;
use Slim\Handlers\NotAllowed;
use Slim\Handlers\Strategies\RequestResponse;
use Slim\CallableResolver;

return [
    'settings' => [
        'httpVersion' => '1.1',
        'responseChunkSize' => 4096,
        'outputBuffering' => 'append',
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => true,
        'addContentLengthHeader' => true,
        'routerCacheFile' => false,
    ],
    'environment' => function () {
        return new Environment($_SERVER);
    },
    'request' => function (ContainerInterface $c) {
        return Request::createFromEnvironment($c->get('environment'));
    },
    'response' => function (ContainerInterface $c) {
        $headers = new Headers(['Content-Type' => 'text/html; charset=UTF-8']);
        $response = new Response(200, $headers);
        return $response->withProtocolVersion($c->get('settings')['httpVersion']);
    },
    'router' => function (ContainerInterface $c) {
        error_log(print_r($c->get('settings'), 1));
        $router = (new Router)->setCacheFile($c->get('settings')['routerCacheFile']);
        if (method_exists($router, 'setContainer')) {
            $router->setContainer($c);
        }

        return $router;
    },
    'foundHandler' => function () {
        return new RequestResponse;
    },
    'phpErrorHandler' => function (ContainerInterface $c) {
        return new PhpError($c->get('settings')['displayErrorDetails']);
    },
    'errorHandler' => function (ContainerInterface $c) {
        return new Error($c->get('settings')['displayErrorDetails']);
    },
    'notFoundHandler' => function () {
        return new NotFound;
    },
    'notAllowedHandler' => function () {
        return new NotAllowed;
    },
    'callableResolver' => function (ContainerInterface $c) {
        return new CallableResolver($c);
    }
];
<?php
declare(strict_types = 1);

namespace Ergosense\Middlewares;

use FastRoute\Dispatcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FastRoute implements MiddlewareInterface
{
    /**
     * Set the Dispatcher instance.
     */
    public function __construct(Dispatcher $router)
    {
        $this->router = $router;
    }

    /**
     * Process a server request and return a response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $route = $this->router->dispatch($request->getMethod(), $request->getUri()->getPath());

        if ($route[0] === Dispatcher::NOT_FOUND) {
            // 404
            throw new \Error('boom');
        }

        if ($route[0] === Dispatcher::METHOD_NOT_ALLOWED) {
            throw new \Error('boom');
            //return $response->withStatus(405)->withHeader('Allow', implode(', ', $route[1]));
        }

        $request = $request->withAttribute('route', $route);

        error_log(print_r($route, true));
        error_log('asd');

        return $handler->handle($request);
    }
}

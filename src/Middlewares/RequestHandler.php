<?php
declare(strict_types = 1);

namespace Ergosense\Middlewares;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;

use Ergosense\CallableResolver;

class RequestHandler implements MiddlewareInterface
{
    /**
     * @var ContainerInterface Used to resolve the handlers
     */
    private $resolver;
    /**
     * Set the resolver instance.
     */
    public function __construct(CallableResolver $resolver)
    {
        $this->resolver = $resolver;
    }
    /**
     * Process a server request and return a response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $route = $request->getAttribute('route');

        $callable = $this->resolver->resolve($route[1]);

        $response = new \Zend\Diactoros\Response();;

        return call_user_func($callable, $request, $response, $route[2]);

        /*
        $requestHandler = $request->getAttribute($this->handlerAttribute);

        if (is_string($requestHandler)) {
            $requestHandler = $this->container->get($requestHandler);
        }

        if ($requestHandler instanceof MiddlewareInterface) {
            return $requestHandler->process($request, $handler);
        }

        if ($requestHandler instanceof RequestHandlerInterface) {
            return $requestHandler->handle($request);
        }

        if (is_callable($requestHandler)) {
            return (new CallableHandler($requestHandler))->process($request, $handler);
        }

        throw new RuntimeException(sprintf('Invalid request handler: %s', gettype($requestHandler)));
        */
    }
}

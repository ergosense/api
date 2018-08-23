<?php
namespace Ergosense;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Zend\Diactoros\Response;

class Stack implements RequestHandlerInterface
{
    private $stack;

    public function __construct()
    {
        // LIFO middleware stack
        $this->stack = new \SplQueue;
    }

    public function with(MiddlewareInterface $middleware)
    {
        $this->stack->push($middleware);
        return $this;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        // TODO use a factory
        $defaultResponse = new Response("php://memory", 501);

        if (!$this->stack->isEmpty()) {
            $middleware = $this->stack->dequeue();
            error_log(get_class($middleware));
            $defaultResponse = $middleware->process($request, $this);
        }

        return $defaultResponse;
    }
}
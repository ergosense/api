<?php
declare(strict_types = 1);

namespace Ergosense\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Ergosense\Service\JwtDecoder;

class JwtAuth implements MiddlewareInterface
{
    private $decoder;

    public function __construct(JwtDecoder $decoder)
    {
        $this->decoder = $decoder;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        error_log(print_r($request, 1));

        return $handler->handle($request);
    }
}
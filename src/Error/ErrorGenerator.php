<?php
namespace Ergosense\Error;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Zend\Stratigility\Utils;

class ErrorGenerator
{
    public function __construct(array $map = [])
    {
        $this->map = $map;
    }

    public function generate(Throwable $e, ServerRequestInterface $request) : ResponseInterface
    {
        $response = new \Zend\Diactoros\Response\JsonResponse([
            'error' => [
                'message'   => $e->getMessage(),
                'trace'     => $e->getTraceAsString()
            ]
        ]);

        return $response->withStatus(Utils::getStatusCode($e, $response));
    }
}
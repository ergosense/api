<?php
declare(strict_types = 1);

namespace Ergosense\Traits;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;

trait DefaultResponder
{
    public function format(array $data) : ResponseInterface
    {
        return new JsonResponse([
            'data' => $data
        ]);
    }
}
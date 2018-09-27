<?php
declare(strict_types = 1);

namespace Ergosense\Route;

use Psr\Http\Message\ServerRequestInterface;

interface RouteBridgeInterface
{
    public function dispatch(ServerRequestInterface $request) : Route;
}
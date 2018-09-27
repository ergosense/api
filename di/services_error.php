<?php
use Psr\Container\ContainerInterface;
use Ergosense\Error\ErrorGenerator;
use Ergosense\Middleware\ErrorHandler;

$services = [
    ErrorHandler::class => function (ContainerInterface $c) {
        return new ErrorHandler($c->get(ErrorGenerator::class));
    },
    ErrorGenerator::class => function (ContainerInterface $c) {
        return new ErrorGenerator;
    }
];

return $services;
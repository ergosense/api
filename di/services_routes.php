<?php
use Psr\Container\ContainerInterface;
use Ergosense\Route\RouteBridgeInterface;
use Ergosense\Route\FastRouteBridge;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use FastRoute\RouteParser;
use FastRoute\DataGenerator;
use FastRoute\Dispatcher\GroupCountBased;
use FastRoute\RouteParser\Std;
use FastRoute\DataGenerator\GroupCountBased as GroupCountBasedGenerator;
use Ergosense\Middleware\RequestHandler;

return [
    /**
     * Ensure the current container is passed to the request
     * handler so we can inject middleware into routes too
     */
    RequestHandler::class => function (ContainerInterface $c) {
      return new RequestHandler(
        $c->get(RouteBridgeInterface::class),
        $c
      );
    },
    /**
     * Default route bridge
     */
    RouteBridgeInterface::class => function (ContainerInterface $c) {
        return new FastRouteBridge($c->get(Dispatcher::class));
    },
    /**
     * Fast Route configuration
     */
    RouteParser::class => function ($c) { return new Std; },
    DataGenerator::class => function ($c) { return new GroupCountBasedGenerator; },
    RouteCollector::class => function ($c) {
        return new RouteCollector(
          $c->get(RouteParser::class),
          $c->get(DataGenerator::class)
        );

        return $collector;
    },
    Dispatcher::class => function ($c) {
        $collector = $c->get(RouteCollector::class);
        return new GroupCountBased($collector->getData());
    },
];
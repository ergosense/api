<?php
namespace Ergosense\RouteLoader;

use FastRoute\RouteCollector;

interface RouteLoaderInterface
{
  public function load(RouteCollector $r);
}
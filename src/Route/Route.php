<?php
namespace Ergosense\Route;

class Route
{
    public $callable;
    public $args;

    public function __construct($callable, $args)
    {
        $this->callable = $callable;
        $this->args = $args;
    }
}
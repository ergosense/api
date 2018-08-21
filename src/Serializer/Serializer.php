<?php
namespace Ergosense\Serializer;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Serializer
{
  private $handlers = [];

  private function checkType($type, $check)
  {
    $match = preg_match('/' . str_replace(['*', '/'], ['.*', '\/'], $check) . '/', $type);
    return $match;
  }

  public function register(SerializerInterface $handler)
  {
    $this->handlers[$handler->type()] = $handler;
    return $this;
  }

  public function getSupportedTypes()
  {
    return array_keys($this->handlers);
  }

  public function canSerialize($check)
  {
    foreach (array_keys($this->handlers) as $type) {
      if ($this->checkType($type, $check)) return true;
    }

    return false;
  }

  public function serialize(Request $request, Response $response)
  {
    // Get accepted content type
    $ct = $request->getHeaderLine('Accept');

    foreach ($this->handlers as $type => $handler) {
      $match = preg_match('/' . str_replace(['*', '/'], ['.*', '\/'], $ct) . '/', $type);

      if ($match || !$ct) {
        return $handler->serialize($response);
      }
    }

    return $response;
  }
}
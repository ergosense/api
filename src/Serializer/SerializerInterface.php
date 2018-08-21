<?php
namespace Ergosense\Serializer;

use Psr\Http\Message\ResponseInterface;

interface SerializerInterface
{
  public function type();

  public function serialize(ResponseInterface $response);
}
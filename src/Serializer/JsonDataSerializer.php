<?php
namespace Ergosense\Serializer;

use Slim\Http\Body;
use Psr\Http\Message\ResponseInterface;
use \Exception;

class JsonDataSerializer implements SerializerInterface
{
  public function type()
  {
    return 'application/json';
  }

  public function serialize(array $data)
  {
    return json_encode([
      'data' => $data
    ]);
  }

  public function serializeError(Exception $err)
  {
    return json_encode([
      'error' => $err->getMessage()
    ]);
  }
}
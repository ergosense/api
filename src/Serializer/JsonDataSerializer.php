<?php
namespace Ergosense\Serializer;

use Slim\Http\Body;
use Psr\Http\Message\ResponseInterface;

class JsonDataSerializer implements SerializerInterface
{
  protected function format($data)
  {
    return [ 'data' => $data ];
  }

  public function type()
  {
    return 'application/json';
  }

  public function serialize(ResponseInterface $response)
  {
    try {
      $data = json_decode((string) $response->getBody(), true);
    } else {
      // TODO logger for warnings
      $data = (string) $response->getBody();
    }

    $json = json_encode($this->format($data));

    $response = $response->withBody(new Body(fopen('php://temp', 'r+')));
    $response->getBody()->write($json);

    return $response->withHeader('Content-Type', $this->type());
  }
}
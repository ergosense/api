<?php
namespace Ergosense\Error;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \Exception;

class ErrorHandler
{
  private $serializer;

  public function __construct(\Ergosense\Serializer\Serializer $serializer)
  {
    $this->serializer = $serializer;
  }

  public function __invoke(Request $request, Response $response, Exception $exception)
  {
    $response = $this->serializer->serialize($exception, $request, $response);

    // TODO http mapping
    return $response->withStatus(500);

  }
}
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

  protected function format(Exception $exception)
  {
    return [
      'error' => $exception->getMessage()
    ];
  }

  public function __invoke(Request $req, Response $res, Exception $e)
  {
    error_log(print_r($e->getTraceAsString(), 1));

    $res = $this->serializer->serialize(
      $this->format($e),
      $req,
      $res
    );

    // TODO http mapping
    return $res->withStatus(500);

  }
}
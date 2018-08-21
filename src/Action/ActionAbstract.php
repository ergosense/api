<?php
namespace Ergosense\Action;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * The action abstract should be used for the Actions/Controllers. They
 * help to clearly define the role between action/responder and also ensures
 * the ContentTypeMiddleware receives the data in a usable format.
 */
abstract class ActionAbstract
{
    private $serializer;

    public function __construct(\Ergosense\Serializer\Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    abstract function run(Request $request, Response $response, $args);

    public function responder($entry)
    {
        return $entry;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $result = $this->run($request, $response, $args);

        $result = $this->responder($result);

        return $this->serializer->serialize($result, $request, $response);
    }
}
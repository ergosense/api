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
    abstract function run(Request $request, Response $response, $args);

    public function responder($entry)
    {
        return $entry;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $result = $this->run($request, $response, $args);

        $result = $this->responder($result);

        // Always work with JSON, we will decode this and
        // serialize it in the requested format later in the chain.
        return json_encode($result);
    }
}
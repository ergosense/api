<?php
namespace Ergosense\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Ergosense\Serializer\Serializer;

class ContentTypeMiddleware
{
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(Request $request, Response $response, $next)
    {
        // TODO body parsers

        // Handle output serialization
        $accept = $request->getHeaderLine('Accept');

        // Check if the serializer supports the requested type
        if (!$this->serializer->canSerialize($accept)) {
            throw new \Error('Unable to serialize');
        }

        $response = $next($request, $response);

        return $this->serializer->serialize($request, $response);
    }
}
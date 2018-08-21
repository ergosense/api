<?php
namespace Ergosense\Responder;

use Ergosense\Serializer\Serializer;

class Base
{
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function respond(array $data, $request, $response)
    {
        return $this->serializer->serialize(
            $data,
            $request,
            $response
        );
    }
}
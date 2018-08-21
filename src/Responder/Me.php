<?php
namespace Ergosense\Responder;

use Ergosense\Serializer\Serializer;

class Me
{
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function format(array $data)
    {
        return [
            'id'        => (int) $data['id'],
            'email'     => $data['email'],
            'role'      => $data['role'],
            'active'    => (boolean) $data['active']
        ];
    }

    public function respond(array $data, $request, $response)
    {
        return $this->serializer->serialize(
            $this->format($data),
            $request,
            $response
        );
    }
}
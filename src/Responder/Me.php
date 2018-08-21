<?php
namespace Ergosense\Responder;

use Ergosense\Serializer\Serializer;

class Me extends Base
{
    protected function format(array $data)
    {
        return [
            'id'        => (int) $data['id'],
            'email'     => $data['email'],
            'role'      => $data['role'],
            'active'    => (boolean) $data['active']
        ];
    }
}
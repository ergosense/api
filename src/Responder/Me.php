<?php
namespace Ergosense\Responder;

use Ergosense\Serializer\Serializer;
use OAF\Responder\Base;

class Me extends Base
{
    protected function format(array $data)
    {
        return parent::format([
            'id'        => (int) $data['id'],
            'email'     => $data['email'],
            'role'      => $data['role'],
            'active'    => (boolean) $data['active']
        ]);
    }
}
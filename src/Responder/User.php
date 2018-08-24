<?php
namespace Ergosense\Responder;

use Ergosense\Responder\Base;

trait User
{
    use Base {
        format as baseFormat;
    }

    public function format(array $data) : array
    {
        return $this->baseFormat([
            'id'        => (int) $data['id'],
            'email'     => $data['email'],
            'role'      => $data['role'],
            'active'    => (boolean) $data['active']
        ]);
    }
}
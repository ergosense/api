<?php
declare(strict_types = 1);

namespace Ergosense\Traits;

use Psr\Http\Message\ResponseInterface;

trait UserResponder
{
    use DefaultResponder {
        format as baseFormat;
    }

    public function format(array $data) : ResponseInterface
    {
        return $this->baseFormat([
            'id'        => (int) @$data['id'],
            'email'     => @$data['email'],
            'role'      => @$data['role'],
            'active'    => (boolean) @$data['active']
        ]);
    }
}
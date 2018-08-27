<?php
declare(strict_types = 1);

namespace Ergosense\Traits;

use Psr\Http\Message\ResponseInterface;

trait LoginResponder
{
    use DefaultResponder {
        format as baseFormat;
    }

    public function format(array $data) : ResponseInterface
    {
        return $this->baseFormat([
            'token' => $data['token']
        ]);
    }
}
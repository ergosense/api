<?php
namespace Ergosense\Responder;

trait Base
{
    public function format(array $data)
    {
        return [
            'data' => $data
        ];
    }
}
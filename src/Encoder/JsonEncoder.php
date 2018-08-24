<?php
declare(strict_types=1);

namespace Ergosense\Encoder;

class JsonEncoder implements EncoderInterface
{
    public function supports() : array
    {
        return ['application/json'];
    }

    public function encode(array $data)
    {
        return json_encode($data);
    }
}
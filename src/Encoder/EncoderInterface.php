<?php
declare(strict_types=1);

namespace Ergosense\Encoder;

interface EncoderInterface
{
    public function supportsExtension() : array;

    public function supports() : array;

    public function encode(array $data);
}
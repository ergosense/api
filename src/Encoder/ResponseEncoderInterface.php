<?php
namespace Ergosense\Encoder;

interface ResponseEncoderInterface
{
    public function encode($request, array $data);
}
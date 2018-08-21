<?php
namespace Ergosense\Serializer;

use \Exception;

interface SerializerInterface
{
  public function type();

  public function serialize(array $data);

  public function serializeError(Exception $data);
}
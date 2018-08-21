<?php
namespace Ergosense\Auth;

use Psr\Http\Message\ServerRequestInterface as Request;

interface AuthInterface
{
  public function authenticate(Request $request);
}
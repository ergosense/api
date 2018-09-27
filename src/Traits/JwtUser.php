<?php
namespace Ergosense\Traits;

use Psr\Http\Message\ServerRequestInterface;
use Ergosense\User\UserInterface;
use Ergosense\User\MemoryUser;
use Ergosense\User\GuestUser;

trait JwtUser
{
    public function authedUser(ServerRequestInterface $request) : UserInterface
    {
        $token = $request->getAttribute('token');

        if (!$token) {
            return new GuestUser;
        } else {
            return new MemoryUser($token['userId'], 'unknown');
        }
    }
}
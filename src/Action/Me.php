<?php
namespace Ergosense\Action;

use Ergosense\Repository\UserRepository as UserRepo;
use Ergosense\Encoder\ResponseEncoderInterface;

class Me
{
    private $userRepo;

    public function __construct(UserRepo $userRepo, ResponseEncoderInterface $s)
    {
        $this->userRepo = $userRepo;
        $this->s = $s;
    }

    public function __invoke($request, $response)
    {
        $response->getBody()->write($this->s->encode($request, ['hello' => true]));
        return $response;
    }
}
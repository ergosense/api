<?php
namespace Ergosense\Action;

use Ergosense\Repository\UserRepository as UserRepo;

class Me
{
    private $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function __invoke($request, $response)
    {
        $response->getBody()->write('boo');
        return $response;
    }
}
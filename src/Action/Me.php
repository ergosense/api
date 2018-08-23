<?php
namespace Ergosense\Action;

class Me
{
    private $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function __invoke($request)
    {
        return 'hello fool';
    }
}
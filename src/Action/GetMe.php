<?php
namespace Ergosense\Action;

use Ergosense\Repository\UserRepository as UserRepo;
use Ergosense\Responder\User as UserResponder;

class GetMe
{
    use UserResponder;

    private $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function __invoke($request, $response)
    {
        $user = $this->userRepo->findById(1);

        return $this->format($user);
    }
}
<?php
namespace Ergosense\Action;

use Ergosense\Repository\UserRepository as UserRepo;
use Ergosense\Responder\User as UserResponder;

use OAF\Auth\Context;

class GetMe
{
    use UserResponder;

    private $userRepo;

    public function __construct(Context $context, UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
        $this->context = $context;
    }

    public function __invoke($request, $response)
    {
        $contextUser = $this->context->getUser();

        $user = $this->userRepo->findById($contextUser->id());

        return $this->format($user);
    }
}
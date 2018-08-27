<?php
namespace Ergosense\Action;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Ergosense\Repository\UserRepository as UserRepo;
use Ergosense\Traits\UserResponder;
use OAF\Traits\JwtUser;

class GetMe implements MiddlewareInterface
{
    use UserResponder, JwtUser;

    private $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $contextUser = $this->authedUser($request);

        $user = $this->userRepo->findById($contextUser->id());

        return $this->format($user);
    }
}
<?php
namespace Ergosense\Action;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Ergosense\Repository\UserRepository;
use Ergosense\Responder\ResponderTrait;

use Ergosense\Responder\Me as Responder;

class Me
{
    private $userRepo;

    private $rs;

    public function __construct(Responder $rs, UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
        $this->rs = $rs;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $userId = $request->getAttribute('user');

        $user = $this->userRepo->findById($userId);

        return $this->rs->respond($user, $request, $response);
    }
}
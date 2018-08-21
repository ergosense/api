<?php
namespace Ergosense\Action;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Ergosense\Repository\UserRepository;
use Ergosense\Responder\ResponderTrait;

class Me extends ActionAbstract
{
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function responder($entry)
    {
        return [
            'id'        => (int) $entry['id'],
            'email'     => $entry['email'],
            'role'      => $entry['role'],
            'active'    => (boolean) $entry['active']
        ];
    }

    public function run(Request $request, Response $response, $args)
    {

        $userId = $request->getAttribute('user');

        $user = $this->userRepo->findById($userId);

        return $user;
    }
}
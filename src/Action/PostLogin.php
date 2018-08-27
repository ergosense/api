<?php
namespace Ergosense\Action;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;

use Ergosense\Repository\UserRepository as UserRepo;
use Ergosense\Service\JwtIssuer;
use Ergosense\Traits\LoginResponder;

class PostLogin implements MiddlewareInterface
{
    use LoginResponder;

    private $userRepo;

    public function __construct(UserRepo $userRepo, JwtIssuer $jwt)
    {
        $this->userRepo = $userRepo;
        $this->jwt = $jwt;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        // TODO some validation
        $body = $request->getParsedBody();

        $user = $this->userRepo->findByEmail($body['email']);

        if (password_verify($body['password'], $user['password'])) {

            $jwt = $this->jwt->issue([
                'id'    => $user['id'],
                'email' => $user['email']
            ]);

            return $this->format(['token' => $jwt]);
        }

        throw new \Error('Unable to authenticate');
    }
}
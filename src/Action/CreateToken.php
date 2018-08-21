<?php
namespace Ergosense\Action;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Ergosense\Repository\UserRepository;
use \Firebase\JWT\JWT;

class CreateToken extends ActionAbstract
{
    private $userRepo;

    private $secret;

    public function __construct(UserRepository $userRepo, $secret)
    {
        $this->userRepo = $userRepo;
        $this->secret = $secret;
    }

    public function issueToken($userId)
    {
        $now = time();

        return [
            'iss'       => 'http://ergosense.io',
            'iat'       => $now,
            'nbf'       => $now,
            'exp'       => $now * (60 * 60 * 24), // 24 hours
            'userId'    => $userId
        ];
    }

    public function run(Request $request, Response $response, $args)
    {
        // TODO some validation

        $body = $request->getParsedBody();

        $user = $this->userRepo->findByEmail($body['email']);

        if (password_verify($body['password'], $user['password'])) {
            $jwt = JWT::encode(
                $this->issueToken($user['id']),
                $this->secret,
                'HS512'
            );

            // TODO responder layer
            return [ 'token' => $jwt ];
        } else {
            // TODO so bad
            return [ 'error' => 'boom' ];
        }
    }
}
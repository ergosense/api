<?php
namespace Ergosense\Action;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Ergosense\Repository\UserRepository as UserRepo;
use \Firebase\JWT\JWT;

use OAF\Responder\Base as Responder;

class Login
{
    private $userRepo;

    private $secret;

    private $rs;

    public function __construct(Responder $rs, UserRepo $userRepo, $secret)
    {
        $this->rs = $rs;
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

    public function __invoke(Request $request, Response $response, $args)
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
            return $this->rs->respond(
                [ 'token' => $jwt ],
                $request,
                $response
            );
        } else {
            // TODO so bad
            return [ 'error' => 'boom' ];
        }
    }
}
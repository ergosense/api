<?php
namespace Ergosense\Service;

use Firebase\JWT\JWT;

class JwtIssuer
{
    public function __construct($domain, $secret, $alg = 'HS512')
    {
        $this->domain = $domain;
        $this->secret = $secret;
        $this->alg = $alg;
    }

    public function issue(array $data)
    {
        $now = time();

        $base = [
            'iss'       => $this->domain,
            'iat'       => $now,
            'nbf'       => $now,
            'exp'       => $now * (60 * 60 * 24), // 24 hours
        ];

        $base += $data;

        return JWT::encode(
            $base,
            $this->secret,
            $this->alg
        );
    }
}
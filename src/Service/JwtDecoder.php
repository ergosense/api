<?php
declare(strict_types = 1);

namespace Ergosense\Service;

use Jose\Component\Core\JWKSet;
use Jose\Component\Signature\JWSLoader

class JwtDecoder
{
    private $jwkSet;

    private $loader;

    public function __construct(JWSLoader $loader, $jwkSet = [])
    {
        $this->jwkSet = JWKSet::createFromJson($jwkSet);
        $this->loader = $loader;
    }

    public function decode($token)
    {
        try {
            $jws = $this->loader->loadAndVerifyWithKeySet($token, $this->jwkSet, $signature);

            return $jws->getPayload();
        } catch (\Exception $e) {
            return null;
        }
    }
}
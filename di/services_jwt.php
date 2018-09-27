<?php
use Psr\Container\ContainerInterface;
use Jose\Component\Signature\JWSLoader;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Signature\Algorithm\RS256;
use Jose\Component\Signature\Serializer\CompactSerializer;
use Jose\Component\Core\Converter\StandardConverter;
use Jose\Component\Signature\JWSVerifier;
use Ergosense\Service\JwtDecoder;

use function DI\autowire;

return [
    /**
     * JWT verification. Parses the AWS Cognito JWT token
     * and verified it against the signed keys.
     */
    JWSLoader::class => function (ContainerInterface $c) {

        // Allowed algorithms
        $algorithmManager = AlgorithmManager::create([ new RS256() ]);

        // Token serializer
        $serializerManager = new CompactSerializer(new StandardConverter());

        // Token verifier
        $jwsVerifier = new JWSVerifier($algorithmManager);

        return new JWSLoader($jwsVerifier, $serializerManager);
    },
    /**
     * The JWT decoder service with JWKs loader
     */
    JwtDecoder::class => function (ContainerInterface $c) {
        error_log("WE ARE HERE");
        return new JwtDecoder(
            $c->get(JWSLoader::class),
            json_decode(file_get_contents(__DIR__ . '/jwks.json'), true)
        );
    }
];
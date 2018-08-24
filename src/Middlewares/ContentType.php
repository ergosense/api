<?php
namespace Ergosense\Middlewares;

use Middlewares\ContentType as BaseContentType;
use Ergosense\Encoder\ResponseEncoderInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ContentType extends BaseContentType
{
    private $accepts = [];

    public function __construct(ResponseEncoderInterface $encoder)
    {
        $encoders = $encoder->getEncoders();
        $format = [];

        foreach ($encoders as $i) {
            $supports = $i->supports();
            $format[implode(",", $supports)] = [
                'extension' => [],
                'mime-type' => $supports,
                'charset'   => true
            ];

            $this->accepts += $supports;
        }

        parent::__construct($format);
    }

    /**
     * Process a server request and return a response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = parent::process($request, $handler);

        return $response->withHeader('Accept', implode(", ", $this->accepts));
    }
}

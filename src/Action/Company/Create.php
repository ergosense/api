<?php
namespace Ergosense\Action\Company;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Ergosense\Repository\CompanyRepository;
use OAF\Error\Exception\NotFound;

class Create
{
    private $companyRepo;

    public function __construct(CompanyRepository $companyRepo)
    {
        $this->companyRepo = $companyRepo;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();

        if ($id = $this->companyRepo->save($body)) {
            throw new \Error('created');
        }

        throw new \Error('poop');
    }
}
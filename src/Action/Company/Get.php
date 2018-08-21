<?php
namespace Ergosense\Action\Company;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Ergosense\Repository\CompanyRepository;
use Ergosense\Action\ActionAbstract;

class Get extends ActionAbstract
{
    private $companyRepo;

    public function __construct(CompanyRepository $companyRepo)
    {
        $this->companyRepo = $companyRepo;
    }

    public function run(Request $request, Response $response, $args)
    {
        return $this->companyRepo->findById($args['companyId']);
    }
}
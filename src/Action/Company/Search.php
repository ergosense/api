<?php
namespace Ergosense\Action\Company;

use Ergosense\Repository\CompanyRepository;

class Search
{
    private $companyRepo;

    public function __construct(CompanyRepository $companyRepo)
    {
        $this->companyRepo = $companyRepo;
    }

    public function __invoke($request, $response, $args)
    {

        $companies = $this->companyRepo->search();

        return $response->withJson($companies);
    }
}
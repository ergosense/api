<?php
namespace Ergosense\Action\Company;

use Ergosense\Repository\CompanyRepository;
use OAF\Responder\Base as Responder;

class Search
{
    private $rs;
    private $companyRepo;

    public function __construct(Responder $rs, CompanyRepository $companyRepo)
    {
        $this->rs = $rs;
        $this->companyRepo = $companyRepo;
    }

    public function __invoke($request, $response, $args)
    {
        $companies = $this->companyRepo->search();

        return $this->rs->respond($companies, $request, $response);
    }
}
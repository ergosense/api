<?php
namespace Ergosense\Action\Company;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Ergosense\Repository\CompanyRepository;
use OAF\Error\Exception\NotFound;

use OAF\Responder\Base as Responder;

class Get
{
    private $rs;
    private $companyRepo;

    public function __construct(Responder $rs, CompanyRepository $companyRepo)
    {
        $this->rs = $rs;
        $this->companyRepo = $companyRepo;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $id = $args['id'];

        if ($company = $this->companyRepo->findById($id)) {
          return $this->rs->respond($company, $request, $response);
        }

        throw new NotFound(sprintf('Company %d does not exist', $id));
    }
}
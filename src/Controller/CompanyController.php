<?php

namespace App\Controller;

use App\DTO\CompanyDTO;
use App\Service\CompanyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class CompanyController extends AbstractController
{
    public function __construct(private readonly CompanyService $companyService) {}
    #[Route('/companies', name: 'show_companies', methods: ['GET'])]
    public function showCompanies(): Response
    {
        $companies = $this->companyService->showCompany();
        return $this->json($companies);
    }

    #[Route('/companies', name: 'add_company', methods: ['POST'])]
    public function addCompany(#[MapRequestPayload] CompanyDTO $dto) : Response {
        $company = $this->companyService->addCompany($dto);
        return $this->json($company);
    }

    #[Route('/companies/{id}', name: 'change_company', requirements: ['id' => '\d+'], methods: ['PATCH']) ]
    public function changeCompanyName($id, #[MapRequestPayload(type : 'string')] array $list): Response {
        $company = $this->companyService->changeName($id, $list["name"]);
        return $this->json($company);
    }

    #[Route('/companies/{id}', name: 'show_company', requirements: ['id' => '\d+'], methods: ['GET']) ]
    public function showCompany(int $id) : Response {
        $company = $this->companyService->readCompany($id);
        return $this->json($company);
    }

    #[Route('/companies/{id}', name: 'delete_company', requirements: ['id' => '\d+'], methods: ['DELETE']) ]
    public function deleteCompany(int $id) : Response {
        $this->companyService->deleteCompany($id);
        return $this->showCompanies();
    }


}

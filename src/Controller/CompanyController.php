<?php

namespace App\Controller;

use App\DTO\CompanyDTO;
use App\Service\CompanyService;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: "Company")]
final class CompanyController extends AbstractController
{

    public function __construct(private readonly CompanyService $companyService) {}
    #[Route('/api/companies', name: 'show_companies', methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Show companies')]
    public function showCompanies(): Response
    {
        $companies = $this->companyService->showCompany();
        return $this->json($companies);
    }

    #[Route('/api/companies', name: 'add_company', methods: ['POST'])]
    #[OA\Response(response: 200, description: 'Add a company')]
    public function addCompany(#[MapRequestPayload] CompanyDTO $dto) : Response {
        $company = $this->companyService->addCompany($dto);
        return $this->json($company);
    }

    #[Route('/api/companies/{id}', name: 'change_company', requirements: ['id' => '\d+'], methods: ['PUT']) ]
    #[OA\Response(response: 200, description: 'Modify a company')]
    public function changeCompany($id, #[MapRequestPayload] CompanyDTO $dto): Response {
        $company = $this->companyService->changeCompany($id, $dto);
        return $this->json($company);
    }

    #[Route('/api/companies/{id}', name: 'show_company', requirements: ['id' => '\d+'], methods: ['GET']) ]
    #[OA\Response(response: 200, description: 'Show a company')]
    public function showCompany(int $id) : Response {
        $company = $this->companyService->readCompany($id);
        return $this->json($company);
    }

    #[Route('/api/companies/{id}', name: 'delete_company', requirements: ['id' => '\d+'], methods: ['DELETE']) ]
    #[OA\Response(response: 200, description: 'Delete a company')]
    public function deleteCompany(int $id) : Response {
        $company = $this->companyService->deleteCompany($id);
        return $this->json($company);
    }

    #[Route('/api/companies/{id}/work-points', name: 'show_company_work_points', requirements: ['id' => '\d+'], methods: ['GET']) ]
    #[OA\Response(response: 200, description: 'Show all work-points of a company')]
    public function showCompanyWorkPoints(int $id): Response {
        $workPoints = $this->companyService->showWorkPoints($id);
        return $this->json($workPoints);
    }

    #[Route('/api/companies/departments', name: 'show_companies_departments', methods: ['GET']) ]
    #[OA\Response(response: 200, description: 'Show all departments of all companies')]
    public function getDepartmentsOfCompany() : Response {
        $companies = $this->companyService->getDepartmentsOfCompany();
        return $this->json($companies);
    }



}

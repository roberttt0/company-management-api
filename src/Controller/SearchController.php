<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\SearchService;

final class SearchController extends AbstractController
{
    public function __construct(
        private SearchService $service
    ) {}
    #[Route('/api/search/employees/', name: 'search_employees_by_first_name', methods: ['GET'])]
    public function findEmployeeByFirstName(#[MapQueryParameter] string $name): Response
    {
        $employees = $this->service->findEmployeeByFirstName($name);
        return $this->json($employees);
    }

    #[Route('/api/search/employees/job', name: 'search_employees_by_job_name', methods: ['GET'])]
    public function findEmployeeByJobName(#[MapQueryParameter] string $job): Response
    {
        $employees = $this->service->findEmployeeByJob($job);
        return $this->json($employees);
    }
}

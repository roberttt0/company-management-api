<?php

namespace App\Controller;

use App\DTO\JobDTO;
use App\Service\JobService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Job")]
final class JobController extends AbstractController
{
    public function __construct(
        private JobService $service
    ) {}

    #[Route('/api/jobs', name: 'show_all_jobs', methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Show all jobs')]
    public function showJobs(): Response
    {
        $jobs = $this->service->getAllJobs();
        return $this->json($jobs);
    }
    #[Route('/api/jobs', name: 'add_job', methods: ['POST'])]
    #[OA\Response(response: 200, description: 'Add a job')]
    public function addJob(#[MapRequestPayload] JobDTO $dto) : Response {
        $job = $this->service->addJob($dto);
        return $this->json($job);
    }

    #[Route('/api/jobs/{id}', name: 'update_job', requirements: ['id' => '\d+'], methods: ['PUT'])]
    #[OA\Response(response: 200, description: 'Update a job')]
    public function updateJob(int $id, #[MapRequestPayload] JobDTO $dto) : Response {
        $job = $this->service->updateJob($id, $dto);
        return $this->json($job);
    }

    #[Route('/api/jobs/{id}', name: 'delete_job', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    #[OA\Response(response: 200, description: 'Delete a job')]
    public function deleteJob(int $id): Response {
        $job = $this->service->deleteJob($id);
        return $this->json($job);
    }

    #[Route('/api/jobs/{id}/employees', name: 'show_all_employees_of_job', requirements: ['id' => '\d+'], methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Show all employees of a job')]
    public function getJobEmployees(int $id): Response {
        $employees = $this->service->showAllEmployeesOfJob($id);
        return $this->json($employees);
    }
}

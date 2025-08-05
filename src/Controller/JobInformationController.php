<?php

namespace App\Controller;

use App\DTO\JobInformationDTO;
use App\Service\JobInformationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Job Information")]
final class JobInformationController extends AbstractController
{
    public function __construct(
        private JobInformationService $service
    )
    {
    }

    #[Route('/api/jobs-information', name: 'show_jobs_information', methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Show all jobs information')]
    public function showJobsInformation(): Response
    {
        $jobsInformation = $this->service->showJobsInformation();
        return $this->json($jobsInformation);
    }

    #[Route('/api/jobs-information', name: 'add_job_information', methods: ['POST'], format: 'json')]
    #[OA\Response(response: 200, description: 'Add a job information')]
    public function addJobInformation(#[MapRequestPayload] JobInformationDTO $dto) : Response {
        $jobInformation = $this->service->addJobInformation($dto);
        return $this->json($jobInformation);
    }

    #[Route('/api/jobs-information/{id}', name: 'modify_job_information', requirements: ['id' => '\d+'], methods: ['PUT'])]
    #[OA\Response(response: 200, description: 'Modify a job information')]
    public function modifyJobInformation(int $id, #[MapRequestPayload] JobInformationDTO $dto) : Response {
        $jobInformation = $this->service->modifyJobInformation($id, $dto);
        return $this->json($jobInformation);
    }

    #[Route('/api/jobs-information/{id}', name: 'delete_job_information', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    #[OA\Response(response: 200, description: 'Delete a job information')]
    public function deleteJobInformation(int $id) : Response {
        $jobInformation = $this->service->deleteJobInformation($id);
        return $this->json($jobInformation);
    }


}

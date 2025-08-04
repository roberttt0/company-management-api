<?php

namespace App\Controller;

use App\DTO\WorkPointDTO;
use App\Service\WorkPointService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class WorkPointController extends AbstractController
{
    public function __construct(
        private readonly WorkPointService $workPointService
    ) {}
    #[Route('/work-points', name: 'show_work_points', methods: ['GET'])]
    public function showWorkPoints(): Response
    {
        $workPoints = $this->workPointService->showWorkPoints();
        return $this->json($workPoints);
    }

    #[Route('/work-points', name: 'add_work_point', methods: ['POST'])]
    public function addWorkPoint(#[MapRequestPayload] WorkPointDTO $dto) : Response {
        $workPoint = $this->workPointService->addWorkPoint($dto);
        return $this->json($workPoint);
    }

    #[Route('/work-points/{id}', name: 'modify_work_point', requirements: ['id' => '\d+'] ,methods: ['PUT'])]
    public function modifyWorkPoint(int $id, #[MapRequestPayload] $dto) : Response {
        $workPoint = $this->workPointService->updateWorkPoint($id, $dto);
        return $this->json($workPoint);
    }

    #[Route('/work-points/{id}', name: 'show_work_point', requirements: ['id' => '\d+'] ,methods: ['GET'])]
    public function showWorkPoint(int $id) : Response {
        $workPoint = $this->workPointService->showWorkPoint($id);
        return $this->json($workPoint);
    }

    #[Route('/work-points/{id}', name: 'delete_work_point', requirements: ['id' => '\d+'] ,methods: ['DELETE'])]
    public function deleteWorkPoint(int $id) : Response {
        $workPoint = $this->workPointService->deleteWorkPoint($id);
        return $this->json($workPoint);
    }

    #[Route('/work-points/{id}/departments', name: 'show_department_work_points', requirements: ['id' => '\d+'] ,methods: ['GET'])]
    public function showDepartments(int $id) : Response {
        $departments = $this->workPointService->showDepartments($id);
        return $this->json($departments);
    }

}

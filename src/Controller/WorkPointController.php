<?php

namespace App\Controller;

use App\DTO\WorkPointDTO;
use App\Service\WorkPointService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Work Point")]
final class WorkPointController extends AbstractController
{
    public function __construct(
        private readonly WorkPointService $workPointService
    ) {}
    #[Route('/api/work-points', name: 'show_work_points', methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Show all work points')]
    public function showWorkPoints(): Response
    {
        $workPoints = $this->workPointService->showWorkPoints();
        return $this->json($workPoints);
    }

    #[Route('/api/work-points', name: 'add_work_point', methods: ['POST'])]
    #[OA\Response(response: 200, description: 'Add a work point')]
    public function addWorkPoint(#[MapRequestPayload] WorkPointDTO $dto) : Response {
        $workPoint = $this->workPointService->addWorkPoint($dto);
        return $this->json($workPoint);
    }

    #[Route('/api/work-points/{id}', name: 'modify_work_point', requirements: ['id' => '\d+'] ,methods: ['PUT'])]
    #[OA\Response(response: 200, description: 'Modify a work point')]
    public function modifyWorkPoint(int $id, #[MapRequestPayload] WorkPointDTO $dto) : Response {
        $workPoint = $this->workPointService->updateWorkPoint($id, $dto);
        return $this->json($workPoint);
    }

    #[Route('/api/work-points/{id}', name: 'show_work_point', requirements: ['id' => '\d+'] ,methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Show al work point')]
    public function showWorkPoint(int $id) : Response {
        $workPoint = $this->workPointService->showWorkPoint($id);
        return $this->json($workPoint);
    }

    #[Route('/api/work-points/{id}', name: 'delete_work_point', requirements: ['id' => '\d+'] ,methods: ['DELETE'])]
    #[OA\Response(response: 200, description: 'Delete a work point')]
    public function deleteWorkPoint(int $id) : Response {
        $workPoint = $this->workPointService->deleteWorkPoint($id);
        return $this->json($workPoint);
    }

    #[Route('/api/work-points/{id}/departments', name: 'show_department_work_points', requirements: ['id' => '\d+'] ,methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Show all departments of a work point')]
    public function showDepartments(int $id) : Response {
        $departments = $this->workPointService->showDepartments($id);
        return $this->json($departments);
    }

    #[Route('/api/work-points/{id}/employees', name: 'show_work_point_employees', requirements: ['id' => '\d+'] ,methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Show all employees of a work point')]
    public function findEmployeesByWorkPointId(int $id) : Response {
        $employees = $this->workPointService->findEmployeesByWorkPointId($id);
        return $this->json($employees);
    }

}

<?php

namespace App\Controller;

use App\DTO\DepartmentInfoDTO;
use App\Service\DepartmentInfoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Department Type")]
final class DepartmentInfoController extends AbstractController
{
    public function __construct(
        private DepartmentInfoService $departmentInfoService
    )
    {
    }

    #[Route('/api/departments-info', name: 'show_department_info', methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Show all department types')]
    public function showDepartments() : Response {
        $department = $this->departmentInfoService->showDepartments();
        return $this->json($department);
    }

    #[Route('/api/departments-info', name: 'add_department_info', methods: ['POST'])]
    #[OA\Response(response: 200, description: 'Add a department type')]
    public function addDepartment(#[MapRequestPayload] DepartmentInfoDTO $dto) : Response {
        $department = $this->departmentInfoService->addDepartment($dto);
        return $this->json($department);
    }

    #[Route('/api/departments-info/{id}', name: 'show_department_info_all', requirements: ['id' => '\d+'], methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Show a department type')]
    public function showDepartmentType(int $id) : Response {
        $departments = $this->departmentInfoService->showDepartmentType($id);
        return $this->json($departments);
    }

    #[Route('/api/departments-info/{id}', name: 'change_department_info', requirements: ['id' => '\d+'], methods: ['PATCH'])]
    #[OA\Response(response: 200, description: 'Modify a department name')]
    public function changeDepartmentName(int $id, #[MapRequestPayload] DepartmentInfoDTO $dto) : Response {
        $departments = $this->departmentInfoService->changeDepartmentName($id, $dto);
        return $this->json($departments);
    }

    #[Route('/api/departments-info/{id}', name: 'delete_department_info', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    #[OA\Response(response: 200, description: 'Delete a department type')]
    function deleteDepartmentInfo(int $id) : Response {
        $departmentInfo = $this->departmentInfoService->deleteDepartmenInfo($id);
        return $this->json($departmentInfo);
    }

}

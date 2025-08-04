<?php

namespace App\Controller;

use App\DTO\DepartmentInfoDTO;
use App\Service\DepartmentInfoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class DepartmentInfoController extends AbstractController
{
    public function __construct(
        private DepartmentInfoService $departmentInfoService
    )
    {
    }

    #[Route('/departments-info', name: 'show_department_info', methods: ['GET'])]
    public function showDepartments() : Response {
        $department = $this->departmentInfoService->showDepartments();
        return $this->json($department);
    }

    #[Route('/departments-info', name: 'add_department_info', methods: ['POST'])]
    public function addDepartment(#[MapRequestPayload] DepartmentInfoDTO $dto) : Response {
        $department = $this->departmentInfoService->addDepartment($dto);
        return $this->json($department);
    }

    #[Route('/departments-info/{id}', name: 'show_department_info_all', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showDepartmentType(int $id) : Response {
        $departments = $this->departmentInfoService->showDepartmentType($id);
        return $this->json($departments);
    }

    #[Route('/departments-info/{id}', name: 'change_department_info', requirements: ['id' => '\d+'], methods: ['PATCH'])]
    public function changeDepartmentName(int $id, #[MapRequestPayload] DepartmentInfoDTO $dto) : Response {
        $departments = $this->departmentInfoService->changeDepartmentName($id, $dto);
        return $this->json($departments);
    }


}

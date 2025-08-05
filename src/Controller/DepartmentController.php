<?php

namespace App\Controller;

use App\DTO\DepartmentDTO;
use App\Service\DepartmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class DepartmentController extends AbstractController
{
    public function __construct(
        private DepartmentService $departmentService
    ) {}

    #[Route('/api/departments', name: 'show_departments', methods: ['GET'])]
    public function showDepartments() : Response {
        $department = $this->departmentService->showDepartments();
        return $this->json($department);
    }

    #[Route('/api/departments', name: 'add_department', methods: ['POST'])]
    public function addDepartment(#[MapRequestPayload] DepartmentDTO $dto) : Response {
        $department = $this->departmentService->addDepartment($dto);
        return $this->json($department);
    }

    #[Route('/api/departments/{id}', name: 'delete_department', requirements: ['id' => '\d+'] , methods: ['DELETE'])]
    public function deleteDepartment(int $id) : Response {
        $department = $this->departmentService->deleteDepartment($id);
        return $this->json($department);
    }

}

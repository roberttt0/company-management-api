<?php

namespace App\Controller;

use App\DTO\DepartmentDTO;
use App\Service\DepartmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Department")]
final class DepartmentController extends AbstractController
{
    public function __construct(
        private DepartmentService $departmentService
    ) {}

//    #[Route('/api/departments', name: 'show_departments', methods: ['GET'])]
//    #[OA\Response(response: 200, description: 'Show departments')]
//    public function showDepartments() : Response {
//        $department = $this->departmentService->showDepartments();
//        return $this->json($department);
//    }

    #[Route('/api/departments', name: 'show_departments', methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Show departments')]
    public function showDepartments() : Response {
        $departments = $this->departmentService->showDepartmentNameAndCompany();
        return $this->json($departments);
    }

    #[Route('/api/departments', name: 'add_department', methods: ['POST'])]
    #[OA\Response(response: 200, description: 'Add a department')]
    public function addDepartment(#[MapRequestPayload] DepartmentDTO $dto) : Response {
        $department = $this->departmentService->addDepartment($dto);
        return $this->json($department);
    }

    #[Route('/api/departments/{id}', name: 'delete_department', requirements: ['id' => '\d+'] , methods: ['DELETE'])]
    #[OA\Response(response: 200, description: 'Remove a department')]
    public function deleteDepartment(int $id) : Response {
        $department = $this->departmentService->deleteDepartment($id);
        return $this->json($department);
    }

    #[Route('/api/departments/{id}/employees', name: 'get_all_employees_of_department', requirements: ['id' => '\d+'] , methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Find all employees of a department')]
    public function findEmployeesByDepartmentId(int $id) : Response {
        $jobs = $this->departmentService->findEmployeesByDepartmentId($id);
        return $this->json($jobs);
    }

    #[Route('/api/departments/{id}/jobs', name: 'get_all_jobs_of_department', requirements: ['id' => '\d+'] , methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Find all jobs of a department')]
    public function getAllJobsOfDepartment(int $id) : Response {
        $jobs = $this->departmentService->getAllJobsOfDepartment($id);
        return $this->json($jobs);
    }

    #[Route('/api/departments/{id}', name : 'modify_department', requirements: ['id' => '\d+'] , methods: ['PUT'])]
    #[OA\Response(response: 200, description: 'Modify a department')]
    public function modifyDepartment(int $id, #[MapRequestPayload] DepartmentDTO $dto) : Response {
        $this->departmentService->modifyDepartment($id, $dto);
        return $this->json($dto);
    }

}

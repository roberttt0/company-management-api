<?php

namespace App\Controller;

use App\DTO\EmployeeDTO;
use App\Service\EmployeeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Employee")]
final class EmployeeController extends AbstractController
{
    public function __construct(
        private EmployeeService $service
    ) {}
//    #[Route('/api/employees', name: 'get_employees', methods: ['GET'])]
//    #[OA\Response(response: 200, description: 'Show all employees')]
//    public function getEmployees(): Response
//    {
//        $employees = $this->service->getEmployees();
//        return $this->json($employees);
//    }

    #[Route('/api/employees', name: 'get_employees', methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Show all employees')]
    public function getEmployees(): Response
    {
        $employees = $this->service->getEmployeeInfo();
        return $this->json($employees);
    }

    #[Route('/api/employees', name: 'add_employee', methods: ['POST'])]
    #[OA\Response(response: 200, description: 'Add an employee')]
    public function addEmployee(#[MapRequestPayload] EmployeeDTO $dto) : Response {
        $employee = $this->service->addEmployee($dto);
        return $this->json($employee);
    }

    #[Route('/api/employees/{id}', name: 'update_employee', requirements: ['id' => '\d+'], methods: ['PUT'])]
    #[OA\Response(response: 200, description: 'Update an employee')]
    public function updateEmployee(int $id, #[MapRequestPayload] EmployeeDTO $dto): Response {
        $employee = $this->service->updateEmployee($id, $dto);
        return $this->json($employee);
    }

    #[Route('/api/employees/{id}', name: 'delete_employee', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    #[OA\Response(response: 200, description: 'Delete an employee')]
    public function deleteEmployee(int $id): Response {
        $employee = $this->service->deleteEmployee($id);
        return $this->json($employee);
    }

    #[Route('/api/employees/job/{id}', name: 'get_employee', requirements: ['id' => '\d+'], methods: ['GET'])]
    #[OA\Response(response: 200, description: 'Find all employees by job id')]
    function findJobById(int $id) : Response {
        $employees = $this->service->findJobById($id);
        return $this->json($employees);
    }
}

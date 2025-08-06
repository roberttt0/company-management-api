<?php

namespace App\Service;

use App\DTO\EmployeeDTO;
use App\DTO\OutputEmployeeDTO;
use App\Entity\Employee;
use AutoMapperPlus\AutoMapperInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeeService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private AutoMapperInterface $mapper
    ) {}

    public function getEmployees(): array {
        $employees = $this->manager->getRepository(Employee::class)->findAll();
        return $this->mapper->mapMultiple($employees, OutputEmployeeDTO::class);
    }

    public function addEmployee(EmployeeDTO $dto) : OutputEmployeeDTO {
        $employee = $this->mapper->map($dto, Employee::class);
        $this->manager->persist($employee);
        $this->manager->flush();
        return $this->mapper->map($employee, OutputEmployeeDTO::class);
    }

    public function updateEmployee(int $id, EmployeeDTO $dto) : OutputEmployeeDTO {
        $dto = $this->mapper->map($dto, Employee::class);
        $employee = $this->manager->getRepository(Employee::class)->find($id);

        if ($employee === null) {
            throw new NotFoundHttpException("Employee with id $id not found");
        }
        $employee->setFirstName($dto->getFirstName());
        $employee->setLastName($dto->getLastName());
        $employee->setEmail($dto->getEmail());
        $employee->setPhoneNumber($dto->getPhoneNumber());
        $employee->setHireDate($dto->getHireDate());
        $employee->setJob($dto->getJob());

        $this->manager->persist($employee);
        $this->manager->flush();

        return $this->mapper->map($employee, OutputEmployeeDTO::class);
    }

    public function deleteEmployee(int $id) : array {
        $employee = $this->manager->getRepository(Employee::class)->find($id);
        if ($employee === null) {
            throw new NotFoundHttpException("Employee with id $id not found");
        }
        $this->manager->remove($employee);
        $this->manager->flush();

        return $this->getEmployees();
    }
}

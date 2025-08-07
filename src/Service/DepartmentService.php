<?php

namespace App\Service;

use App\DTO\DepartmentDTO;
use App\DTO\OutputDepartmentDTO;
use App\DTO\OutputEmployeeDTO;
use App\DTO\OutputJobDTO;
use App\Entity\Department;
use AutoMapperPlus\AutoMapperInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Repository\DepartmentRepository;

class DepartmentService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private AutoMapperInterface $mapper,
        private DepartmentRepository $repository
    ) {}

    public function showDepartments() : array {
        $departments = $this->manager->getRepository(Department::class)->findAll();
        return $this->mapper->mapMultiple($departments, OutputDepartmentDTO::class);
    }

    public function addDepartment(DepartmentDTO $dto) : OutputDepartmentDTO {
        $department = $this->mapper->map($dto, Department::class);
        $this->manager->persist($department);
        $this->manager->flush();
        return $this->mapper->map($department, OutputDepartmentDTO::class);
    }

    public function deleteDepartment(int $id) : array {
        $department = $this->manager->getRepository(Department::class)->find($id);
        if ($department == null) {
            throw new NotFoundHttpException("Departamentul nu exista");
        }
        $this->manager->remove($department);
        $this->manager->flush();
        return $this->showDepartments();
    }

    public function getAllJobsOfDepartment(int $id) : array {
        $department = $this->manager->getRepository(Department::class)->find($id);
        return $this->mapper->mapMultiple($department->getJobs(), OutputJobDTO::class);
    }

    public function findEmployeesByDepartmentId(int $id) : array {
        $employees = $this->repository->findEmployeesByDepartmentId($id);
        return $this->mapper->mapMultiple($employees, OutputEmployeeDTO::class);
    }

    public function modifyDepartment(int $id, DepartmentDTO $dto) : OutputDepartmentDTO {
        $department = $this->manager->getRepository(Department::class)->find($id);
        $dto = $this->mapper->map($dto, Department::class);
        $department->setStatus($dto->getStatus());
        $department->setPhoneNumber($dto->getPhoneNumber());
        $department->setEmail($dto->getEmail());
        $department->setDepartment($dto->getDepartment());
        $department->setWorkPoint($dto->getWorkPoint());

        $this->manager->persist($department);
        $this->manager->flush();

        return $this->mapper->map($department, OutputDepartmentDTO::class);

    }

}

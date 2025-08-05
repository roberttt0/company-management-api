<?php

namespace App\Service;

use App\DTO\DepartmentDTO;
use App\DTO\OutputDepartmentDTO;
use App\Entity\Department;
use AutoMapperPlus\AutoMapperInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DepartmentService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private AutoMapperInterface $mapper
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

}

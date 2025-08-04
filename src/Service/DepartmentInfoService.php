<?php

namespace App\Service;

use App\DTO\DepartmentDTO;
use App\DTO\DepartmentInfoDTO;
use App\Entity\DepartmentInfo;
use AutoMapperPlus\AutoMapperInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DepartmentInfoService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private AutoMapperInterface $mapper
    )
    {
    }

    public function showDepartments() : array {
        $info = [];
        $departments = $this->manager->getRepository(DepartmentInfo::class)->findAll();
        foreach ($departments as $department) {
            $info[] = $department->getName();
        }
        return $info;
    }

    public function addDepartment(DepartmentInfoDTO $dto) : DepartmentInfo {
        $department = $this->mapper->map($dto, DepartmentInfo::class);
        $this->manager->persist($department);
        $this->manager->flush();
        return $department;
    }

    public function showDepartmentType(int $id) : array {
        $departmentInfo = $this->manager->getRepository(DepartmentInfo::class)->find($id);
        if ($departmentInfo === null) {
            throw new NotFoundHttpException("Departamentul nu exista!");
        }
        return $this->mapper->mapMultiple($departmentInfo->getDepartmentsList(), DepartmentDTO::class);
    }

    public function changeDepartmentName(int $id, DepartmentInfoDTO $dto) : string {
        $departmentInfo = $this->manager->getRepository(DepartmentInfo::class)->find($id);
        if ($departmentInfo === null) {
            throw new NotFoundHttpException("Departamentul nu exista!");
        }
        $departmentInfo->setName($dto->name);
        $this->manager->persist($departmentInfo);
        $this->manager->flush();
        return $departmentInfo->getName();
    }
}

<?php

namespace App\Service;

use App\DTO\DepartmentInfoDTO;
use App\DTO\OutputDepartmentDTO;
use App\DTO\OutputDepartmentInfoDTO;
use App\DTO\OutputEmployeeDTO;
use App\Entity\DepartmentInfo;
use AutoMapperPlus\AutoMapperInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Repository\DepartmentInfoRepository;

class DepartmentInfoService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private AutoMapperInterface    $mapper,
        private DepartmentInfoRepository $repository
    )
    {
    }

    public function showDepartments(): array
    {
        $info = [];
        $departments = $this->manager->getRepository(DepartmentInfo::class)->findAll();
        foreach ($departments as $department) {
            $department = $this->mapper->map($department, OutputDepartmentInfoDTO::class);
            $info[] = $department;
        }
        return $info;
    }

    public function addDepartment(DepartmentInfoDTO $dto): OutputDepartmentInfoDTO
    {
        $department = $this->mapper->map($dto, DepartmentInfo::class);
        $this->manager->persist($department);
        $this->manager->flush();
//        return $department;
        return $this->mapper->map($department, OutputDepartmentInfoDTO::class);
    }

    public function showDepartmentType(int $id): array
    {
        $departmentInfo = $this->manager->getRepository(DepartmentInfo::class)->find($id);
        if ($departmentInfo === null) {
            throw new NotFoundHttpException("Departamentul nu exista!");
        }
        return $this->mapper->mapMultiple($departmentInfo->getDepartmentsList(), OutputDepartmentDTO::class);
    }

    public function changeDepartmentName(int $id, DepartmentInfoDTO $dto): OutputDepartmentInfoDTO
    {
        $departmentInfo = $this->manager->getRepository(DepartmentInfo::class)->find($id);
        if ($departmentInfo === null) {
            throw new NotFoundHttpException("Departamentul nu exista!");
        }
        $departmentInfo->setName($dto->name);
        $this->manager->persist($departmentInfo);
        $this->manager->flush();
        return $this->mapper->map($departmentInfo, OutputDepartmentInfoDTO::class);
    }

    public function deleteDepartmentInfo(int $id): array
    {
        $departmentInfo = $this->manager->getRepository(DepartmentInfo::class)->find($id);
        if ($departmentInfo === null) {
            throw new NotFoundHttpException("Departamentul nu exista!");
        }
        $this->manager->remove($departmentInfo);
        $this->manager->flush();

        return $this->showDepartments();
    }

    public function findEmployeesByDepartmentInfoId(int $id): array
    {
        $employees = $this->repository->findEmployeesByDepartmentInfoId($id);
        return $this->mapper->mapMultiple($employees, OutputEmployeeDTO::class);
    }
}

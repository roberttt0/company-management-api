<?php

namespace App\MappingProfile;

use App\DTO\DepartmentDTO;
use App\DTO\OutputDepartmentDTO;
use App\Entity\Company;
use App\Entity\Department;
use App\Entity\DepartmentInfo;
use App\Entity\WorkPoint;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DepartmentProfile implements AutoMapperConfiguratorInterface
{
    public function __construct(
        private EntityManagerInterface $manager
    )
    {
    }

    public function configure(AutoMapperConfigInterface $config): void
    {
        $config->registerMapping(DepartmentDTO::class, Department::class)
            ->forMember('status', function (DepartmentDTO $dto) {
                return $dto->status;
            })
            ->forMember('phoneNumber', function (DepartmentDTO $dto) {
                return $dto->phoneNumber;
            })
            ->forMember('email', function (DepartmentDTO $dto) {
                return $dto->email;
            })
            ->forMember('department', function (DepartmentDTO $dto) {
                $departmentInfo = $this->manager->getRepository(DepartmentInfo::class)->find($dto->department);
                if ($departmentInfo == null) {
                    throw new NotFoundHttpException("Departamentul nu exista");
                }
                return $departmentInfo;
            })
            ->forMember('workPoint', function (DepartmentDTO $dto) {
                $workPoint = $this->manager->getRepository(WorkPoint::class)->find($dto->workPoint);
                if ($workPoint == null) {
                    throw new NotFoundHttpException("Punctul de lucru nu exista");
                }
                return $workPoint;
            });

        $config->registerMapping(Department::class, OutputDepartmentDTO::class)
            ->forMember('id', function (Department $department) {
                return $department->getId();
            })
            ->forMember('status', function (Department $department) {
                return $department->getStatus();
            })
            ->forMember('phoneNumber', function (Department $departament) {
                return $departament->getPhoneNumber();
            })
            ->forMember('email', function (Department $departament) {
                return $departament->getEmail();
            })
            ->forMember('department', function (Department $departament) {
                return $departament->getDepartment()->getId();
            })
            ->forMember('workPoint', function (Department $departament) {
                return $departament->getWorkPoint()->getId();
            })
            ->forMember('dateCreated', function (Department $company) {
                return $company->getCreatedAt()->format('c');
            })
            ->forMember('dateUpdated', function (Department $company) {
                return $company->getUpdatedAt()->format('c');
            });
    }
}

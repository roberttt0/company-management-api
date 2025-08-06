<?php

namespace App\MappingProfile;

use App\DTO\EmployeeDTO;
use App\DTO\OutputEmployeeDTO;
use App\Entity\Employee;
use App\Entity\Job;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeeProfile implements AutoMapperConfiguratorInterface
{
    public function __construct(
        private EntityManagerInterface $manager
    )
    {
    }

    public function configure(AutoMapperConfigInterface $config) : void {
        $config->registerMapping(EmployeeDTO::class, Employee::class)
            ->forMember('firstName', function (EmployeeDTO $dto) {
                return $dto->firstName;
            })
            ->forMember('lastName', function (EmployeeDTO $dto) {
                return $dto->lastName;
            })
            ->forMember('email', function (EmployeeDTO $dto) {
                return $dto->email;
            })
            ->forMember('phoneNumber', function (EmployeeDTO $dto) {
                return $dto->phoneNumber;
            })
            ->forMember('hireDate', function (EmployeeDTO $dto) {
                return new \DateTime($dto->hireDate);
            })
            ->forMember('job', function (EmployeeDTO $dto) {
                $job = $this->manager->getRepository(Job::class)->find($dto->job);
                if ($job == null) {
                    throw new NotFoundHttpException("Job not found");
                }
                return $job;
            })
            ;

        $config->registerMapping(Employee::class, OutputEmployeeDTO::class)
            ->forMember('firstName', function (Employee $employee) {
                return $employee->getFirstName();
            })
            ->forMember('lastName', function (Employee $employee) {
                return $employee->getLastName();
            })
            ->forMember('email', function (Employee $employee) {
                return $employee->getEmail();
            })
            ->forMember('phoneNumber', function (Employee $employee) {
                return $employee->getPhoneNumber();
            })
            ->forMember('hireDate', function (Employee $employee) {
                return $employee->getHireDate()->format('Y-m-d');
            })
            ->forMember('job', function (Employee $employee) {
                return $employee->getJob()->getId();
            })
            ->forMember('createdAt', function (Employee $employee) {
                return $employee->getCreatedAt()->format('c');
            })
            ->forMember('updatedAt', function (Employee $employee) {
                return $employee->getUpdatedAt()->format('c');
            })
            ;
    }
}

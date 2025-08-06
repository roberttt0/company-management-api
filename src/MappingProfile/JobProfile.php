<?php

namespace App\MappingProfile;

use App\DTO\JobDTO;
use App\DTO\OutputJobDTO;
use App\Entity\Department;
use App\Entity\Job;
use App\Entity\JobInformation;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JobProfile implements AutoMapperConfiguratorInterface
{
    public function __construct(
        private EntityManagerInterface $manager
    ) {}
    public function configure(AutoMapperConfigInterface $config) : void {
        $config->registerMapping(JobDTO::class, Job::class)
            ->forMember('salary', function (JobDTO $dto) {
                return $dto->salary;
            })
            ->forMember('jobType', function (JobDTO $dto) {
                $jobType = $this->manager->getRepository(JobInformation::class)->find($dto->jobType);
                if ($jobType == null) {
                    throw new NotFoundHttpException("Job type does not exist");
                }
                return $jobType;
            })
            ->forMember('department', function (JobDTO $dto) {
                $department = $this->manager->getRepository(Department::class)->find($dto->department);
                if ($department == null) {
                    throw new NotFoundHttpException("Department does not exist");
                }
                return $department;
            })
            ;

        $config->registerMapping(Job::class, OutputJobDTO::class)
            ->forMember('id', function (Job $job) {
                return $job->getId();
            })
            ->forMember('salary', function (Job $job) {
                return $job->getSalary();
            })
            ->forMember('jobType', function (Job $job) {
                return $job->getJobType()->getId();
            })
            ->forMember('department', function (Job $job) {
                return $job->getDepartment()->getId();
            })
            ->forMember('createdAt', function (Job $job) {
                return $job->getCreatedAt()->format('c');
            })
            ->forMember('updatedAt', function (Job $job) {
                return $job->getUpdatedAt()->format('c');
            })
            ;
    }
}

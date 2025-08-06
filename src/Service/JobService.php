<?php

namespace App\Service;

use App\DTO\JobDTO;
use App\DTO\OutputJobDTO;
use App\Entity\Job;
use AutoMapperPlus\AutoMapperInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JobService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private AutoMapperInterface    $mapper
    )
    {
    }

    public function showJobs() : array
    {
        $jobs = $this->manager->getRepository(Job::class)->findAll();
        return $this->mapper->mapMultiple($jobs, OutputJobDTO::class);
    }

    public function addJob(JobDTO $dto) : OutputJobDTO {
        $job = $this->mapper->map($dto, Job::class);
        $this->manager->persist($job);
        $this->manager->flush();

        return $this->mapper->map($job, OutputJobDTO::class);
    }

    public function updateJob(int $id, JobDTO $dto) : OutputJobDTO {
        $dto = $this->mapper->map($dto, Job::class);
        $job = $this->manager->getRepository(Job::class)->find($id);

        if ($job === null) {
            throw new NotFoundHttpException("Job with id $id not found");
        }

        $job->setSalary($dto->getSalary());
        $job->setJobType($dto->getJobType());
        $job->setDepartment($dto->getDepartment());

        $this->manager->persist($job);
        $this->manager->flush();

        return $this->mapper->map($job, OutputJobDTO::class);
    }

    public function deleteJob(int $id) : array {
        $job = $this->manager->getRepository(Job::class)->find($id);
        if ($job === null) {
            throw new NotFoundHttpException("Job does not exist");
        }
        $this->manager->remove($job);
        $this->manager->flush();

        return $this->showJobs();
    }
}

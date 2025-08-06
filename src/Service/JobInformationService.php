<?php

namespace App\Service;

use App\DTO\JobInformationDTO;
use App\DTO\OutputJobInformationDTO;
use App\Entity\JobInformation;
use AutoMapperPlus\AutoMapperInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JobInformationService
{
    public function __construct(
        private AutoMapperInterface $mapper,
        private EntityManagerInterface $manager
    ) {}

    public function showJobsInformation() : array {
        $jobsInformation = $this->manager->getRepository(JobInformation::class)->findAll();
        return $this->mapper->mapMultiple($jobsInformation, OutputJobInformationDTO::class);
    }

    public function addJobInformation(JobInformationDTO $dto) : OutputJobInformationDTO {
        $jobInformation = $this->mapper->map($dto, JobInformation::class);
        $this->manager->persist($jobInformation);
        $this->manager->flush();
        return $this->mapper->map($jobInformation, OutputJobInformationDTO::class);
    }

    public function modifyJobInformation(int $id, JobInformationDTO $dto) : OutputJobInformationDTO {
        $dto = $this->mapper->map($dto, JobInformation::class);
        $jobInformation = $this->manager->getRepository(JobInformation::class)->find($id);

        $jobInformation->setName($dto->getName());
        $this->manager->persist($jobInformation);
        $this->manager->flush();

        return $this->mapper->map($jobInformation, OutputJobInformationDTO::class);
    }

    public function deleteJobInformation(int $id) : array {
        $jobInformation = $this->manager->getRepository(JobInformation::class)->find($id);
        if ($jobInformation === null) {
            throw new NotFoundHttpException("Job information does not exist!");
        }
        $this->manager->remove($jobInformation);
        $this->manager->flush();

        return $this->showJobsInformation();
    }
}

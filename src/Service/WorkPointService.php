<?php

namespace App\Service;

use App\DTO\OutputDepartmentDTO;
use App\DTO\OutputEmployeeDTO;
use App\DTO\OutputWorkPointDTO;
use App\DTO\WorkPointDTO;
use App\Entity\WorkPoint;
use AutoMapperPlus\AutoMapperInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Repository\WorkPointRepository;

class WorkPointService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private AutoMapperInterface    $mapper,
        private WorkPointRepository $repository
    )
    {
    }

    public function showWorkPoints(): array
    {
        $points = $this->manager->getRepository(WorkPoint::class)->findAll();
        $points = $this->mapper->mapMultiple($points, OutputWorkPointDTO::class);
        return $points;
    }

    public function addWorkPoint(WorkPointDTO $dto): OutputWorkPointDTO
    {
        $workPoint = $this->mapper->map($dto, WorkPoint::class);
        $this->manager->persist($workPoint);
        $this->manager->flush();
        return $this->mapper->map($workPoint, OutputWorkPointDTO::class);
    }

    public function updateWorkPoint(int $id, WorkPointDTO $dto): OutputWorkPointDTO
    {
        $workPoint = $this->manager->getRepository(WorkPoint::class)->find($id);
        $dto = $this->mapper->map($dto, WorkPoint::class);
        $workPoint->setAddress($dto->getAddress());
        $workPoint->setCounty($dto->getCounty());
        $workPoint->setType($dto->getType());
        $workPoint->setPhoneNumber($dto->getPhoneNumber());
        $workPoint->setProgramStart($dto->getProgramStart());
        $workPoint->setProgramEnd($dto->getProgramEnd());
        $workPoint->setCompany($dto->getCompany());

        $this->manager->persist($workPoint);
        $this->manager->flush();

        return $this->mapper->map($workPoint, OutputWorkPointDTO::class);
    }

    public function showWorkPoint(int $id): OutputWorkPointDTO
    {
        $workPoint = $this->manager->getRepository(WorkPoint::class)->find($id);
        if ($workPoint === null) {
            throw new NotFoundHttpException("Work point not found");
        }
        $workPoint = $this->mapper->map($workPoint, OutputWorkPointDTO::class);
        return $workPoint;
    }

    public function deleteWorkPoint(int $id): array
    {
        $workPoint = $this->manager->getRepository(WorkPoint::class)->find($id);
        if ($workPoint === null) {
            throw new NotFoundHttpException("Work point not found");
        }
        $this->manager->remove($workPoint);
        $this->manager->flush();

        return $this->showWorkPoints();
    }

    public function showDepartments(int $id): array
    {
        $workPoint = $this->manager->getRepository(WorkPoint::class)->find($id);
        if ($workPoint === null) {
            throw new NotFoundHttpException("Work point not found");
        }
        return $this->mapper->mapMultiple($workPoint->getDepartments(), OutputDepartmentDTO::class);
    }

    public function findEmployeesByWorkPointId(int $id) : array {
        $employees = $this->repository->findEmployeesByWorkPointId($id);
        return $this->mapper->mapMultiple($employees, OutputEmployeeDTO::class);
    }
}

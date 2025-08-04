<?php

namespace App\Service;

use App\DTO\DepartmentDTO;
use App\DTO\WorkPointDTO;
use App\Entity\WorkPoint;
use AutoMapperPlus\AutoMapperInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WorkPointService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private AutoMapperInterface $mapper
    ) {}

    public function showWorkPoints() : array {
        $points = $this->manager->getRepository(WorkPoint::class)->findAll();
        $points = $this->mapper->mapMultiple($points, WorkPointDTO::class);
        return $points;
    }

    public function addWorkPoint(WorkPointDTO $dto) : WorkPointDTO {
        $workPoint = $this->mapper->map($dto, WorkPoint::class);
        $this->manager->persist($workPoint);
        $this->manager->flush();
        return $dto;
    }

    public function updateWorkPoint(int $id, WorkPointDTO $dto) : WorkPoint {
        $workPoint = $this->manager->getRepository(WorkPoint::class)->find($id);
        $dto = $this->mapper->map($dto, WorkPoint::class);
        $workPoint->setAddress($dto->address);
        $workPoint->setCounty($dto->county);
        $workPoint->setType($dto->type);
        $workPoint->setPhoneNumber($dto->phoneNumber);
        $workPoint->setProgramStart($dto->programStart);
        $workPoint->setProgramEnd($dto->programEnd);
        $workPoint->setIdCompanie($workPoint->getIdCompanie());

        $this->manager->persist($workPoint);
        $this->manager->flush();

        return $workPoint;
    }

    public function showWorkPoint(int $id) : WorkPointDTO {
        $workPoint = $this->manager->getRepository(WorkPoint::class)->find($id);
        if ($workPoint === null) {
            throw new NotFoundHttpException("Punctul de lucru nu exista!");
        }
        $workPoint = $this->mapper->map($workPoint, WorkPointDTO::class);
        return $workPoint;
    }

    public function deleteWorkPoint(int $id) : array {
        $workPoint = $this->manager->getRepository(WorkPoint::class)->find($id);
        $this->manager->remove($workPoint);
        $this->manager->flush();

        return $this->showWorkPoints();
    }

    public function showDepartments(int $id) : array {
        $workPoint = $this->manager->getRepository(WorkPoint::class)->find($id);
        if ($workPoint === null) {
            throw new NotFoundHttpException("Punctul de lucru nu exista!");
        }
        return $this->mapper->mapMultiple($workPoint->getDepartments(), DepartmentDTO::class);
    }
}

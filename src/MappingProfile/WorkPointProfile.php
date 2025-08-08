<?php

namespace App\MappingProfile;

use App\DTO\OutputWorkPointDTO;
use App\DTO\WorkPointDTO;
use App\Entity\Company;
use App\Entity\WorkPoint;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WorkPointProfile implements AutoMapperConfiguratorInterface
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    public function configure(AutoMapperConfigInterface $config): void
    {
        $config->registerMapping(WorkPointDTO::class, WorkPoint::class)
            ->forMember('address', function (WorkPointDTO $dto) {
                return $dto->address;
            })
            ->forMember('county', function (WorkPointDTO $dto) {
                return $dto->county;
            })
            ->forMember('type', function (WorkPointDTO $dto) {
                return $dto->type;
            })
            ->forMember('phoneNumber', function (WorkPointDTO $dto) {
                return $dto->phoneNumber;
            })
            ->forMember('programStart', function (WorkPointDTO $dto) {
                return \DateTime::createFromFormat('H:i', $dto->programStart);
            })
            ->forMember('programEnd', function (WorkPointDTO $dto) {
                return \DateTime::createFromFormat('H:i', $dto->programEnd);
            })
            ->forMember('company', function (WorkPointDTO $dto) {
                $company = $this->manager->getRepository(Company::class)->find($dto->company);
                if ($company == null) {
                    throw new NotFoundHttpException("Company not found");
                }
                return $company;
            });

        $config->registerMapping(WorkPoint::class, OutputWorkPointDTO::class)
            ->forMember('id', function (WorkPoint $workPoint) {
                return $workPoint->getId();
            })
            ->forMember('address', function (WorkPoint $workPoint) {
                return $workPoint->getAddress();
            })
            ->forMember('county', function (WorkPoint $workPoint) {
                return $workPoint->getCounty();
            })
            ->forMember('type', function (WorkPoint $workPoint) {
                return $workPoint->getType();
            })
            ->forMember('phoneNumber', function (WorkPoint $workPoint) {
                return $workPoint->getPhoneNumber();
            })
            ->forMember('programStart', function (WorkPoint $workPoint) {
                return $workPoint->getProgramStart()->format('H:i');
            })
            ->forMember('programEnd', function (WorkPoint $workPoint) {
                return $workPoint->getProgramEnd()->format('H:i');
            })
            ->forMember('company', function (WorkPoint $workPoint) {
                return $workPoint->getCompany()->getId();
            })
            ->forMember('dateCreated', function (WorkPoint $company) {
                return $company->getCreatedAt()->format('c');
            })
            ->forMember('dateUpdated', function (WorkPoint $company) {
                return $company->getUpdatedAt()->format('c');
            });
    }
}

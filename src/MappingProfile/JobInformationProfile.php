<?php

namespace App\MappingProfile;

use App\DTO\JobInformationDTO;
use App\DTO\OutputJobInformationDTO;
use App\Entity\Company;
use App\Entity\JobInformation;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;

class JobInformationProfile implements AutoMapperConfiguratorInterface
{
    public function configure(AutoMapperConfigInterface $config): void
    {
        $config->registerMapping(JobInformationDTO::class, JobInformation::class)
            ->forMember('name', function (JobInformationDTO $dto) {
                return $dto->name;
            });

        $config->registerMapping(JobInformation::class, OutputJobInformationDTO::class)
            ->forMember('id', function (JobInformation $jobInformation) {
                return $jobInformation->getId();
            })
            ->forMember('name', function (JobInformation $jobInformation) {
                return $jobInformation->getName();
            })
            ->forMember('createdAt', function (JobInformation $company) {
                return $company->getCreatedAt()->format('c');
            })
            ->forMember('updatedAt', function (JobInformation $company) {
                return $company->getUpdatedAt()->format('c');
            });
    }
}

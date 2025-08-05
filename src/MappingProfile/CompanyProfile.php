<?php

namespace App\MappingProfile;

use App\DTO\CompanyDTO;
use App\DTO\OutputCompanyDTO;
use App\Entity\Company;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;

class CompanyProfile implements AutoMapperConfiguratorInterface
{
    public function configure(AutoMapperConfigInterface $config): void {
        $config->registerMapping(CompanyDTO::class, Company::class)
        ->forMember('name', function(CompanyDTO $dto) {
            return $dto->name;
        })
        ->forMember('cui', function(CompanyDTO $dto) {
            return $dto->cui;
        })
        ->forMember('yearCreated', function(CompanyDTO $dto) {
            return $dto->yearCreated;
        })
        ->forMember('parentId', function (CompanyDTO $dto) {
            return $dto->parentId;
        })
        ;

        $config->registerMapping(Company::class, OutputCompanyDTO::class)
            ->forMember('id', function(Company $company) {
                return $company->getId();
            })
            ->forMember('name', function(Company $company) {
                return $company->getName();
            })
            ->forMember('cui', function(Company $company) {
                return $company->getCui();
            })
            ->forMember('yearCreated', function(Company $company) {
                return $company->getYearCreated();
            })
            ->forMember('parentId', function (Company $company) {
                return $company->getParentId();
            })
            ;
    }
}

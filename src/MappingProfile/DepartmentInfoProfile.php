<?php

namespace App\MappingProfile;

use App\DTO\DepartmentInfoDTO;
use App\DTO\OutputDepartmentInfoDTO;
use App\Entity\DepartmentInfo;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;

class DepartmentInfoProfile implements AutoMapperConfiguratorInterface
{
    public function configure(AutoMapperConfigInterface $config) : void {
        $config->registerMapping(DepartmentInfoDTO::class, DepartmentInfo::class)
            ->forMember('name', function(DepartmentInfoDTO $dto) {
                return $dto->name;
            })
            ;

        $config->registerMapping(DepartmentInfo::class, OutputDepartmentInfoDTO::class)
            ->forMember('id', function(DepartmentInfo $departmentInfo) {
                return $departmentInfo->getId();
            })
            ->forMember('name', function(DepartmentInfo $departmentInfo) {
                return $departmentInfo->getName();
            })
            ;
    }
}

<?php

namespace App\DTO;

use App\Entity\DepartmentInfo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(fields: ['name'], entityClass: DepartmentInfo::class)]
class DepartmentInfoDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name
    )
    {
    }
}

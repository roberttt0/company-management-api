<?php

namespace App\DTO;

use App\Entity\JobInformation;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\NotBlank;

#[UniqueEntity(fields: ['name'], entityClass: JobInformation::class)]
class JobInformationDTO
{
    public function __construct(
        #[NotBlank(message: "IS required")]
        public string $name
    ) {}
}

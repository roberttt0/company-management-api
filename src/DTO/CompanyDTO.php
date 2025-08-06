<?php

namespace App\DTO;

use App\Entity\Company;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(fields: ['name'], entityClass: Company::class)]
class CompanyDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 3, max: 20)]
        public string $name,
        #[Assert\NotBlank]
        public string    $cui,
        #[Assert\NotBlank]
        public int    $yearCreated,
        public ?int   $parentId = null
    )
    {}
}

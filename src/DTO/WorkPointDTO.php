<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class WorkPointDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,
        #[Assert\NotBlank]
        public string $address,
        #[Assert\NotBlank]
        public string $county,
        #[Assert\NotBlank]
        public string $type,
        #[Assert\NotBlank]
        public string $phoneNumber,
        #[Assert\NotBlank]
        public string $programStart,
        #[Assert\NotBlank]
        public string $programEnd,
        public int    $company
    )
    {
    }
}

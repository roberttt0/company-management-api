<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class EmployeeDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 3, max: 20)]
        public string $firstName,
        #[Assert\NotBlank]
        #[Assert\Length(min: 3, max: 20)]
        public string $lastName,
        #[Assert\Email]
        #[Assert\NotBlank]
        public string $email,
        #[Assert\NotBlank]
        public string $phoneNumber,
        #[Assert\NotBlank]
        public string $hireDate,
        public int $job
    ) {}
}

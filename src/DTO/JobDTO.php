<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class JobDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public int $salary,
        public int $jobType,
        public int $department
    ) {}
}

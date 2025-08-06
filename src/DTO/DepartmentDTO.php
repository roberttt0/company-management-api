<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class DepartmentDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Choice(['activ', 'inactiv'])]
        public string $status,
        #[Assert\NotBlank]
        public string $phoneNumber,
        #[Assert\NotBlank]
        public string $email,
        public int    $department,
        public int    $workPoint
    )
    {
    }
}

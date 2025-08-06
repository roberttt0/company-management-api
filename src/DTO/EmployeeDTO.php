<?php

namespace App\DTO;

class EmployeeDTO
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $phoneNumber,
        public string $hireDate,
        public int $job
    ) {}
}

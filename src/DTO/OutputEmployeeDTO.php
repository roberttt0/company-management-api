<?php

namespace App\DTO;

class OutputEmployeeDTO
{
    public function __construct(
        public int $id,
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $phoneNumber,
        public string $hireDate,
        public string $job,
        public string $createdAt,
        public string $updatedAt
    ) {}
}

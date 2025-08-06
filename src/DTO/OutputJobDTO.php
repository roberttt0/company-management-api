<?php

namespace App\DTO;

class OutputJobDTO
{
    public function __construct(
        public int $id,
        public int $salary,
        public int $jobType,
        public int $department,
        public string $createdAt,
        public string $updatedAt
    ) {}
}

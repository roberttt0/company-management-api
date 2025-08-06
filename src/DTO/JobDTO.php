<?php

namespace App\DTO;

class JobDTO
{
    public function __construct(
        public int $salary,
        public int $jobType,
        public int $department
    ) {}
}

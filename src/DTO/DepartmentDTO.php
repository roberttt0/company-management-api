<?php

namespace App\DTO;

class DepartmentDTO
{
    public function __construct(
        public string $status,
        public string $phoneNumber,
        public string $email,
        public int    $department,
        public int    $workPoint
    )
    {
    }
}

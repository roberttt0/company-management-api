<?php

namespace App\DTO;

class OutputDepartmentDTO
{
    public function __construct(
        public int $id,
        public string $status,
        public string $phoneNumber,
        public string $email,
        public int    $department,
        public int    $workPoint
    )
    {
    }
}

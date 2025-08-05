<?php

namespace App\DTO;

class OutputDepartmentInfoDTO
{
    public function __construct(
        public int $id,
        public string $name
    )
    {
    }
}

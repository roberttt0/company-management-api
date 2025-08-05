<?php

namespace App\DTO;

class OutputCompanyDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string    $cui,
        public int    $yearCreated,
        public ?int   $parentId = null
    )
    {}
}

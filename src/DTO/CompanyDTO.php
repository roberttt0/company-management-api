<?php

namespace App\DTO;

class CompanyDTO
{
    public function __construct(
        public string $name,
        public string    $cui,
        public int    $dateCreated,
        public ?int   $parentId = null
    )
    {}
}

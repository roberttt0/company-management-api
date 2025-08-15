<?php

namespace App\DTO;

class OutputWorkPointDTO
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $address,
        public string $county,
        public string $type,
        public string $phoneNumber,
        public string $programStart,
        public string $programEnd,
        public int    $company,
        public ?string $dateCreated,
        public ?string $dateUpdated
    )
    {
    }
}

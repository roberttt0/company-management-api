<?php

namespace App\DTO;

class WorkPointDTO
{
    public function __construct(
        public string $address,
        public string $county,
        public string $type,
        public string $phoneNumber,
        public string $programStart,
        public string $programEnd,
        public int    $company
    )
    {
    }
}

<?php

namespace App\DTO;

class OutputJobInformationDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $dateCreated,
        public ?string $dateUpdated
    ) {}
}

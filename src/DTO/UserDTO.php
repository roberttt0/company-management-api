<?php

namespace App\DTO;

class UserDTO
{
    public function __construct(
        public $username,
        public $password
    ) {}
}

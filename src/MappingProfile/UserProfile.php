<?php

namespace App\MappingProfile;

use App\DTO\UserDTO;
use App\Entity\User;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;

class UserProfile implements AutoMapperConfiguratorInterface
{
    public function configure(AutoMapperConfigInterface $config) : void {
        $config->registerMapping(UserDTO::class, User::class)
            ->forMember('username', function (UserDTO $dto) {
                return $dto->username;
            })
            ->forMember('password', function (UserDTO $dto) {
                return $dto->password;
            })
            ;
    }
}

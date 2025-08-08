<?php

namespace App\Service;

use App\DTO\UserDTO;
use App\Entity\ApiToken;
use App\Entity\User;
use AutoMapperPlus\AutoMapperInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class LoginService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private AutoMapperInterface $mapper,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function logIn(UserDTO $dto) : string {
        $myUser = $this->mapper->map($dto, User::class);
        $users = $this->manager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            if ($myUser->getUsername() === $user->getUsername() && $this->passwordHasher->hashPassword($user, $myUser->getPassword())) {
                $apiTokens = $this->manager->getRepository(ApiToken::class)->findAll();
                foreach ($apiTokens as $token) {
                    if ($token->getUser() === $user) {
                        $user->setApiToken(null);
                        $this->manager->remove($token);
                        $this->manager->flush();
                    }
                }
                $accessToken = bin2hex(random_bytes(32));
                $apiToken = new ApiToken();
                $apiToken->setToken($accessToken);
                $apiToken->setUser($user);
                $apiToken->setExpiryDate(new \DateTime('+24 hours'));
                $this->manager->persist($apiToken);
                $this->manager->flush();
                return $accessToken;
            }
        }
        throw new UserNotFoundException("Invalid login details");
    }

    public function register(UserDTO $dto) : string {
        $user = $this->mapper->map($dto, User::class);
        $users = $this->manager->getRepository(User::class)->findAll();
        foreach($users as $dbUser) {
            if ($dbUser->getUsername() === $user->getUsername()) {
                throw new CustomUserMessageAuthenticationException("Username already taken");
            }
        }
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $user->getPassword()
        );
        $user->setPassword($hashedPassword);
        $this->manager->persist($user);
        $this->manager->flush();
        return "User registered successfully";
    }
}

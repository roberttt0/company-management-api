<?php

namespace App\Controller;

use App\DTO\UserDTO;
use App\Service\LoginService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class LoginController extends AbstractController
{
    public function __construct(
        private LoginService $loginService
    ) {}
    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function logIn(#[MapRequestPayload] UserDTO $dto): Response
    {
        $token = $this->loginService->login($dto);
        return $this->json($token);
    }

    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(#[MapRequestPayload] UserDTO $dto) : Response {
        $user= $this->loginService->register($dto);
        return $this->json($user);
    }
}

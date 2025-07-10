<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Entity\User;

final class UserApiController extends AbstractController
{
    #[Route('/admin/user', name: 'user_account_v1', methods: ['GET','OPTIONS'])]
    public function execute(#[CurrentUser] User $user): JsonResponse
    {
        return $this->json([
            'email' => $user->getUserIdentifier(),
            'api_key' => $user->getApiKey(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'roles' => $user->getRoles(),
        ]);
    }
}

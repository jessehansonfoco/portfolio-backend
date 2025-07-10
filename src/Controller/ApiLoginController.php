<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

#[AsController]
class ApiLoginController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    ){}

    #[Route('/login/api', name: 'api_login', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user, Request $request): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $apiKey = sha1(microtime() . md5($user->getPassword()));
        $user->setApiKey($apiKey);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json([
            'email' => $user->getUserIdentifier(),
            'api_key' => $apiKey,
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'roles' => $user->getRoles(),
        ]);
    }
}

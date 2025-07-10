<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use App\Entity\User;
use App\Repository\UserRepository;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function getUserBadgeFrom(#[\SensitiveParameter] string $accessToken): UserBadge
    {
        $user = $this->userRepository->findOneBy([User::API_KEY => $accessToken]);
        if (is_null($accessToken) || !$user || !$user->getId()) {
            throw new BadCredentialsException('Invalid credentials.');
        }
        return new UserBadge($user->getEmail());
    }
}

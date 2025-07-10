<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[Index(name: "IDX_USER_EMAIL", columns: ["email"])]
#[Index(name: "IDX_USER_API_KEY", columns: ["api_key"])]
#[Index(name: "IDX_USER_FIRST_NAME", columns: ["first_name"])]
#[Index(name: "IDX_USER_LAST_NAME", columns: ["last_name"])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';
    const COMPANY = 'company';
    const EMAIL = 'email';
    const API_KEY = 'api_key';
    const ROLES = 'roles';
    const CREATED_AT = 'created_at';
    const LOCKED_AT = 'locked_at';
    const LAST_LOGIN_AT = 'last_login_at';
    const PASSWORD_UPDATED_AT = 'password_updated_at';
    const LOCALE = 'locale';
    const CONFIRM_HASH = 'confirm_hash';
    const FAILED_LOGINS = 'failed_logins';
    const IS_ENABLED = 'is_enabled';
    const IS_CONFIRMED = 'is_confirmed';
    const IS_LOCKED = 'is_locked';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    // ADDED PROPERTIES BELOW

    #[ORM\Column(type: 'string', length: 100, unique: true, nullable: true)]
    private ?string $api_key;

    #[ORM\Column(length: 128, nullable: true)]
    private ?string $first_name = null;

    #[ORM\Column(length: 128, nullable: true)]
    private ?string $last_name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    // ADDED METHODS BELOW

    public function setApiKey(string $apiKey = null): static
    {
        $this->api_key = $apiKey;
        return $this;
    }

    public function getApiKey(): ?string
    {
        return $this->api_key;
    }

    /**
     * @param string|null $firstName
     * @return $this
     */
    public function setFirstName(string $firstName = null): static
    {
        $this->first_name = $firstName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setLastName(string $lastName = null): static
    {
        $this->last_name = $lastName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }
}

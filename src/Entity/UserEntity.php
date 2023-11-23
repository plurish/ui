<?php

namespace App\Entity;

use App\Enum\RoleEnum;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table('user')]
#[UniqueEntity(fields: ['username', 'email'], message: 'Username e/ou e-mail já em uso')]
class UserEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true, nullable: false)]
    private string $username = '';

    #[ORM\Column(length: 150, unique: true, nullable: false)]
    private string $email = '';

    #[ORM\Column(nullable: false, options: ['default' => false])]
    private bool $active = false;

    #[ORM\Column(nullable: false)]
    private array $roles = ['ROLE_PLAYER'];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private string $password = '';

    public function __construct(
        string $username,
        string $email,
        string $password,
        bool $active = false,
        array $roles = ['ROLE_PLAYER'],
    ) {
        $this->username = $username;
        $this->email = $email;
        $this->roles = $roles;
        $this->password = $password;
        $this->active = $active;
        $this->roles = $roles;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
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

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $newValue): static
    {
        $this->active = $newValue;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        if (!count($this->roles))
            $this->addRole(RoleEnum::ROLE_PLAYER);

        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole(RoleEnum $role): static
    {
        $this->roles[] = (string) $role;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
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
}

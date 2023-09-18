<?php

declare(strict_types=1);

namespace App\Core\Factory\User;

use App\Core\Factory\DataFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class DummyUserFactoryData extends DataFactory
{

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private ?Uuid $id = null,
        private ?string $email = null,
        private ?string $password = null,
        private ?array $roles = null,
        private ?Collection $tasks = null,
    ) {
        parent::__construct();

        if ($id === null) {
            $this->id = Uuid::v4();
        }

        if ($email === null) {
            $this->email = $this->faker->email();
        }

        if ($password === null) {
            $this->password = $this->faker->password();
        }

        if ($tasks === null) {
            $this->tasks = new ArrayCollection();
        }

        if ($roles === null) {
            $this->roles = ['ROLE_USER'];
        }
    }

    public function getPasswordHasher(): UserPasswordHasherInterface
    {
        return $this->passwordHasher;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getTasks(): ?Collection
    {
        return $this->tasks;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }
}
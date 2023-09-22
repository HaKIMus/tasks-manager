<?php

namespace App\Authentication\Domain\Model;

use App\Authentication\Infrastructure\Dbal\Repository\UserRepository;
use App\Tasks\Domain\Model\Task;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Column(type: 'string')]
    private string $password;

    private function __construct(
        #[Id]
        #[Column(type: 'uuid')]
        private Uuid $id,

        #[Column(type: 'string', length: 180, unique: true)]
        private ?string $email,

        /**
         * @var Collection<int, Task>
         */
        #[OneToMany(mappedBy: 'user', targetEntity: Task::class, cascade: ['persist', 'remove'])]
        private Collection $tasks = new ArrayCollection(),

        /**
         * @var array<string>
         */
        #[Column(type: 'json')]
        private array $roles = ['ROLE_USER'],
    ) {
        if (empty($this->roles)) {
            $this->roles[] = 'ROLE_USER';
        }
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): void
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
        }
    }

    public function removeTask(Task $task): void
    {
        $this->tasks->removeElement($task);
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $newPassword): self
    {
        $this->password = $newPassword;

        return $this;
    }

    public function getSalt(): string
    {
        return $_ENV["SALT"] ?: "9067845067348956238";
    }

    public function eraseCredentials(): void
    {
    }

    /**
     * @param array<string> $roles
     * @param Collection<int, Task> $tasks
     */
    public static function createUser(
        UserPasswordHasherInterface $hasher,
        Uuid $id,
        string $email,
        string $password,
        array $roles,
        Collection $tasks,
    ): User {
        $user = new User(
            $id,
            $email,
            $tasks,
            $roles
        );

        $hashedPassword = $hasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        return $user;
    }
}

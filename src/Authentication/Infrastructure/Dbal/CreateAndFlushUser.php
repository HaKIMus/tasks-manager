<?php

declare(strict_types=1);

namespace App\Authentication\Infrastructure\Dbal;

use App\Authentication\Domain\Model\User;
use App\Core\Factory\DataFactory;
use App\Core\Factory\UserFactory;
use Doctrine\ORM\EntityManagerInterface;

readonly class CreateAndFlushUser
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    /**
     * @template T of DataFactory
     * @param UserFactory<T> $userFactory
     * @param DataFactory    $data
     *
     * @return User
     */
    public function create(UserFactory $userFactory, DataFactory $data): User
    {
        $user = $userFactory->create($data);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

}
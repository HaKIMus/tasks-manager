<?php

declare(strict_types=1);

namespace App\Tests\Common\Contract;

use App\Authentication\Infrastructure\Dbal\CreateAndFlushUser;
use App\Authentication\Infrastructure\Factory\DummyUserFactory;
use App\Authentication\Infrastructure\Factory\DummyUserFactoryData;
use App\Core\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

abstract class AppWebTestCase extends WebTestCase
{
    protected ContainerInterface $container;
    protected KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();

        $this->container = static::getContainer();

        /** @var UserPasswordHasherInterface $hasher */
        $hasher = $this->container->get(UserPasswordHasherInterface::class);

        /** @var CreateAndFlushUser $createAndFlushService */
        $createAndFlushService = $this->container->get(CreateAndFlushUser::class);

        /** @var UserFactory<DummyUserFactory> $userFactory */
        $userFactory = $this->container->get(DummyUserFactory::class);

        $user = $createAndFlushService->create($userFactory, new DummyUserFactoryData(
            passwordHasher: $hasher,
            email: 'user@example.com',
            password: 'password',
        ));

        $this->client->loginUser($user);
    }
}
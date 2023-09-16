<?php

declare(strict_types=1);

namespace App\Tests\Common\Contract;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

/**
 * @template T
 */
abstract class AbstractRepositoryTestCase extends KernelTestCase
{
    use ResetDatabase;

    protected ?EntityManagerInterface $entityManager;

    /** @var T */
    protected readonly mixed $repository;

    protected string $repositoryClass;

    protected readonly ContainerInterface $container;

    protected function setUp(): void
    {
        parent::setUp();

        $kernel = self::bootKernel();
        $this->assertSame('test', $kernel->getEnvironment());

        $this->entityManager = $kernel->getContainer()
          ->get('doctrine')
          ->getManager();

        $this->container = static::getContainer();

        $this->repository = $this->container->get($this->repositoryClass);
    }

    /**
     * @param class-string $repositoryClass
     * @template R
     *
     * @return R
     */
    protected function retrieveRepository(string $repositoryClass): mixed
    {
        $container = static::getContainer();
        return $container->get($repositoryClass);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }

}
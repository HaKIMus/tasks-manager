<?php

declare(strict_types=1);

namespace App\Tasks\Ui\Api\V1;

use App\Authentication\Domain\User;
use App\Common\Contract\AppController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/v1/tasks')]
final class TaskV1Controller extends AbstractController implements AppController
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    #[Route('/{id}', name: 'task', methods: ['GET'])]
    public function getTasks(): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var User $user */
        $user = $this->getUser();

        return JsonResponse::fromJsonString(
            $this->serializer->serialize($user->getTasks()->toArray(), 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['user']]),
        );
    }
}
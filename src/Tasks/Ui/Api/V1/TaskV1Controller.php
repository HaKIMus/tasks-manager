<?php

declare(strict_types=1);

namespace App\Tasks\Ui\Api\V1;

use App\Authentication\Domain\Model\User;
use App\Common\Contract\AppController;
use App\Tasks\Domain\UserTasksResource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

#[Route('api/v1/tasks')]
final class TaskV1Controller extends AbstractController implements AppController
{

    public function __construct(
      private readonly SerializerInterface $serializer,
      private readonly UserTasksResource $userTasksResource,
    ) {}

    #[Route('/{id}', name: 'api_task', methods: ['GET'])]
    public function getTask(Uuid $id): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var User $user */
        $user = $this->getUser();
        $this->userTasksResource->findForUserByTaskId($user, $id);

        return JsonResponse::fromJsonString(
          $this->serializer->serialize(
            $user->getTasks()->toArray(),
            'json',
            [AbstractNormalizer::IGNORED_ATTRIBUTES => ['user']]
          )
        );
    }

    #[Route('/', name: 'api_tasks', methods: ['GET'])]
    public function getTasks(): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var User $user */
        $user = $this->getUser();

        return JsonResponse::fromJsonString(
          $this->serializer->serialize(
            $user->getTasks()->toArray(),
            'json',
            [AbstractNormalizer::IGNORED_ATTRIBUTES => ['user']]
          )
        );
    }

}
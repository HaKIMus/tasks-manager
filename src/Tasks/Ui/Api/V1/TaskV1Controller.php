<?php

declare(strict_types=1);

namespace App\Tasks\Ui\Api\V1;

use App\Authentication\Domain\Model\User;
use App\Core\Contract\AppController;
use App\Core\Factory\TaskFactory;
use App\Tasks\Application\Service\UpdateTaskCategory;
use App\Tasks\Domain\UserTasksResource;
use App\Tasks\Ui\Api\V1\Model\TaskV1Dto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\InvalidArgumentException;

#[Route('api/v1/tasks')]
final class TaskV1Controller extends AbstractController implements AppController
{

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly UserTasksResource $userTasksResource,
        /** @var TaskFactory<TaskV1Dto> */
        private readonly TaskFactory $tasksFactory,
        private readonly UpdateTaskCategory $updateTaskCategory,
    ) {
    }

    #[Route('/{id}', name: 'api_v1_get_task', methods: ['GET'])]
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

    #[Route(name: 'api_v1_get_tasks', methods: ['GET'])]
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

    #[Route(name: 'api_v1_post_tasks', methods: ['POST'])]
    public function postTask(Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var User $user */
        $user = $this->getUser();

        try {
            $payload = TaskV1Dto::createFromPayload($request->getPayload());
            $payload->appendUser($user);
        } catch (InvalidArgumentException $e) {
            return $this->json(
                $e->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $task = $this->tasksFactory->create($payload);
        } catch (InvalidArgumentException $e) {
            return $this->json(
                $e->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        }

        $this->userTasksResource->save($task);

        return $this->json(
            sprintf("Resource of id %s created.", $task->getId()->toRfc4122()),
            Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'api_v1_put_task', methods: ['PUT'])]
    public function updateTask(Request $request, Uuid $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var User $user */
        $user = $this->getUser();

        $task = $this->userTasksResource->findForUserByTaskId($user, $id);
        $categoryName = $request->getPayload()->get('category_name', null);

        if (!$categoryName) {
            return $this->json(
                'Category name is required.',
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $this->updateTaskCategory->update($task, $categoryName);
        } catch (InvalidArgumentException $e) {
            return $this->json(
                $e->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json('Resource updated.', Response::HTTP_OK);
    }

}
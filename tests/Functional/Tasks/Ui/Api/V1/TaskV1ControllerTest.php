<?php

declare(strict_types=1);

namespace App\Tests\Functional\Tasks\Ui\Api\V1;

use App\Tests\Common\Contract\AppWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

final class TaskV1ControllerTest extends AppWebTestCase
{
    private Uuid $id;

    public function setUp(): void
    {
        parent::setUp();

        $this->id = Uuid::v4();
    }

    /**
     * @depends testPostTask
     */
    public function testGetTask(): void
    {
        $this->client->request('GET', '/api/v1/tasks/' . $this->id->toRfc4122());

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testGetTasks(): void
    {
        $this->client->request('GET', '/api/v1/tasks');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testPostTask(): void
    {
        $payload = [
            'id' => $this->id->toRfc4122(),
            'name' => 'test task',
            'description' => 'test description',
            'status' => 'pending',
            'category_name' => 'General',
            'due_to' => '2023-01-01'
        ];

        $this->client->request('POST', '/api/v1/tasks', $payload, [], [
            'CONTENT_TYPE' => 'application/json',
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }
}
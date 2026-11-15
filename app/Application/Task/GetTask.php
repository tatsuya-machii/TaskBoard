<?php

namespace App\Application\Task;

use App\Application\Task\DTO\TaskData;
use App\Domain\Task\TaskId;
use App\Domain\Task\TaskRepository;

final class GetTask
{
    public function __construct(private TaskRepository $tasks) {}

    public function handle(string $id): TaskData
    {
        return TaskData::fromEntity($this->tasks->get(TaskId::fromString($id)));
    }
}

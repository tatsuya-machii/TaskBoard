<?php

namespace App\Application\Task;

use App\Domain\Task\TaskId;
use App\Domain\Task\TaskRepository;

final class DeleteTask
{
    public function __construct(private TaskRepository $tasks) {}

    public function handle(string $id): void
    {
        $taskId = TaskId::fromString($id);
        $this->tasks->get($taskId); // 存在確認(なければ TaskNotFound)
        $this->tasks->delete($taskId);
    }
}

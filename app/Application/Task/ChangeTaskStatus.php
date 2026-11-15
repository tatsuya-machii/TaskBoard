<?php

namespace App\Application\Task;

use App\Domain\Task\TaskId;
use App\Domain\Task\TaskRepository;
use App\Domain\Task\TaskStatus;
use DateTimeImmutable;

final class ChangeTaskStatus
{
    public function __construct(private TaskRepository $tasks) {}

    public function handle(string $id, TaskStatus $status): void
    {
        $task = $this->tasks->get(TaskId::fromString($id));
        $task->changeStatus($status, new DateTimeImmutable);

        $this->tasks->save($task);
    }
}

<?php

namespace App\Application\Task;

use App\Domain\Task\TaskDescription;
use App\Domain\Task\TaskId;
use App\Domain\Task\TaskRepository;
use App\Domain\Task\TaskTitle;
use DateTimeImmutable;

final class UpdateTask
{
    public function __construct(private TaskRepository $tasks) {}

    public function handle(string $id, string $title, ?string $description): void
    {
        $task = $this->tasks->get(TaskId::fromString($id));
        $task->edit(
            TaskTitle::fromString($title),
            TaskDescription::fromString($description ?? ''),
            new DateTimeImmutable,
        );

        $this->tasks->save($task);
    }
}

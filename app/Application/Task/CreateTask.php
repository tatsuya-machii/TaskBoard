<?php

namespace App\Application\Task;

use App\Domain\Task\Task;
use App\Domain\Task\TaskDescription;
use App\Domain\Task\TaskId;
use App\Domain\Task\TaskRepository;
use App\Domain\Task\TaskTitle;
use DateTimeImmutable;

final class CreateTask
{
    public function __construct(private TaskRepository $tasks) {}

    public function handle(string $title, ?string $description): TaskId
    {
        $task = Task::create(
            TaskId::generate(),
            TaskTitle::fromString($title),
            TaskDescription::fromString($description ?? ''),
            new DateTimeImmutable,
        );

        $this->tasks->save($task);

        return $task->id();
    }
}

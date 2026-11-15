<?php

namespace App\Application\Task\DTO;

use App\Domain\Task\Task;
use App\Domain\Task\TaskStatus;

/** 画面へ渡す読み取り専用データ。 */
final readonly class TaskData
{
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public TaskStatus $status,
        public string $createdAt,
        public string $updatedAt,
    ) {}

    public static function fromEntity(Task $task): self
    {
        return new self(
            $task->id()->value(),
            $task->title()->value(),
            $task->description()->value(),
            $task->status(),
            $task->createdAt()->format('Y-m-d H:i'),
            $task->updatedAt()->format('Y-m-d H:i'),
        );
    }
}

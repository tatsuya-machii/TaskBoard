<?php

namespace App\Domain\Task;

use DateTimeImmutable;

/** タスク集約ルート。不変条件と状態遷移はここで守る。 */
final class Task
{
    private function __construct(
        private readonly TaskId $id,
        private TaskTitle $title,
        private TaskDescription $description,
        private TaskStatus $status,
        private readonly DateTimeImmutable $createdAt,
        private DateTimeImmutable $updatedAt,
    ) {}

    /** 新規作成(常に To Do から始まる)。 */
    public static function create(TaskId $id, TaskTitle $title, TaskDescription $description, DateTimeImmutable $now): self
    {
        return new self($id, $title, $description, TaskStatus::Todo, $now, $now);
    }

    /** 永続化層からの復元用。 */
    public static function reconstitute(
        TaskId $id,
        TaskTitle $title,
        TaskDescription $description,
        TaskStatus $status,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
    ): self {
        return new self($id, $title, $description, $status, $createdAt, $updatedAt);
    }

    public function edit(TaskTitle $title, TaskDescription $description, DateTimeImmutable $now): void
    {
        $this->title = $title;
        $this->description = $description;
        $this->updatedAt = $now;
    }

    public function changeStatus(TaskStatus $status, DateTimeImmutable $now): void
    {
        if ($this->status === $status) {
            return;
        }

        $this->status = $status;
        $this->updatedAt = $now;
    }

    public function id(): TaskId
    {
        return $this->id;
    }

    public function title(): TaskTitle
    {
        return $this->title;
    }

    public function description(): TaskDescription
    {
        return $this->description;
    }

    public function status(): TaskStatus
    {
        return $this->status;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}

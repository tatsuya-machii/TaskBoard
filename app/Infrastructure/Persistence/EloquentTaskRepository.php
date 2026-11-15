<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Task\Exception\TaskNotFound;
use App\Domain\Task\Task;
use App\Domain\Task\TaskDescription;
use App\Domain\Task\TaskId;
use App\Domain\Task\TaskRepository;
use App\Domain\Task\TaskStatus;
use App\Domain\Task\TaskTitle;
use DateTimeImmutable;

final class EloquentTaskRepository implements TaskRepository
{
    public function get(TaskId $id): Task
    {
        $model = EloquentTaskModel::find($id->value());

        if ($model === null) {
            throw TaskNotFound::withId($id);
        }

        return $this->toEntity($model);
    }

    public function all(): array
    {
        return EloquentTaskModel::query()
            ->orderBy('created_at')
            ->orderBy('id')
            ->get()
            ->map(fn (EloquentTaskModel $m) => $this->toEntity($m))
            ->all();
    }

    public function save(Task $task): void
    {
        $model = EloquentTaskModel::find($task->id()->value()) ?? new EloquentTaskModel;

        $model->id = $task->id()->value();
        $model->title = $task->title()->value();
        $model->description = $task->description()->isEmpty() ? null : $task->description()->value();
        $model->status = $task->status()->value;
        $model->created_at = $task->createdAt();
        $model->updated_at = $task->updatedAt();
        $model->save();
    }

    public function delete(TaskId $id): void
    {
        EloquentTaskModel::whereKey($id->value())->delete();
    }

    private function toEntity(EloquentTaskModel $m): Task
    {
        return Task::reconstitute(
            TaskId::fromString($m->id),
            TaskTitle::fromString($m->title),
            $m->description === null ? TaskDescription::empty() : TaskDescription::fromString($m->description),
            TaskStatus::from($m->status),
            DateTimeImmutable::createFromInterface($m->created_at),
            DateTimeImmutable::createFromInterface($m->updated_at),
        );
    }
}

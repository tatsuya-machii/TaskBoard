<?php

namespace App\Domain\Task;

interface TaskRepository
{
    /** @throws Exception\TaskNotFound */
    public function get(TaskId $id): Task;

    /** @return list<Task> 作成日時の昇順 */
    public function all(): array;

    public function save(Task $task): void;

    public function delete(TaskId $id): void;
}

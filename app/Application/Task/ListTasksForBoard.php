<?php

namespace App\Application\Task;

use App\Application\Task\DTO\TaskData;
use App\Domain\Task\TaskRepository;
use App\Domain\Task\TaskStatus;

final class ListTasksForBoard
{
    public function __construct(private TaskRepository $tasks) {}

    /**
     * ステータスごとにグルーピングしたタスク一覧。全ステータスのキーを必ず含む。
     *
     * @return array<string, list<TaskData>> キーは TaskStatus の value
     */
    public function handle(): array
    {
        $board = [];
        foreach (TaskStatus::cases() as $status) {
            $board[$status->value] = [];
        }

        foreach ($this->tasks->all() as $task) {
            $board[$task->status()->value][] = TaskData::fromEntity($task);
        }

        return $board;
    }
}

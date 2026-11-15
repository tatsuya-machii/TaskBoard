<?php

namespace App\Domain\Task\Exception;

use App\Domain\Task\TaskId;
use RuntimeException;

final class TaskNotFound extends RuntimeException
{
    public static function withId(TaskId $id): self
    {
        return new self("タスクが見つかりません: {$id->value()}");
    }
}

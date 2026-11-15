<?php

namespace App\Domain\Task;

enum TaskStatus: string
{
    case Todo = 'todo';
    case InProgress = 'in_progress';
    case Done = 'done';

    public function label(): string
    {
        return match ($this) {
            self::Todo => 'To Do',
            self::InProgress => '進行中',
            self::Done => '完了',
        };
    }

    /** ボード上で一つ右の列(なければ null)。 */
    public function next(): ?self
    {
        return match ($this) {
            self::Todo => self::InProgress,
            self::InProgress => self::Done,
            self::Done => null,
        };
    }

    /** ボード上で一つ左の列(なければ null)。 */
    public function previous(): ?self
    {
        return match ($this) {
            self::Todo => null,
            self::InProgress => self::Todo,
            self::Done => self::InProgress,
        };
    }
}

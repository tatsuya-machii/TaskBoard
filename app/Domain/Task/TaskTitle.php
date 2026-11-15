<?php

namespace App\Domain\Task;

use App\Domain\Task\Exception\InvalidTaskTitle;

/** タスクのタイトル(値オブジェクト)。必須・最大100文字。 */
final readonly class TaskTitle
{
    public const MAX_LENGTH = 100;

    private function __construct(private string $value) {}

    public static function fromString(string $value): self
    {
        $value = trim($value);

        if ($value === '') {
            throw InvalidTaskTitle::empty();
        }

        if (mb_strlen($value) > self::MAX_LENGTH) {
            throw InvalidTaskTitle::tooLong(self::MAX_LENGTH);
        }

        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}

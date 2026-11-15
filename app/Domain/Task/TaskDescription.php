<?php

namespace App\Domain\Task;

use App\Domain\Task\Exception\InvalidTaskDescription;

/** タスクの説明(値オブジェクト)。任意・最大1000文字。 */
final readonly class TaskDescription
{
    public const MAX_LENGTH = 1000;

    private function __construct(private string $value) {}

    public static function fromString(string $value): self
    {
        $value = trim($value);

        if (mb_strlen($value) > self::MAX_LENGTH) {
            throw InvalidTaskDescription::tooLong(self::MAX_LENGTH);
        }

        return new self($value);
    }

    public static function empty(): self
    {
        return new self('');
    }

    public function value(): string
    {
        return $this->value;
    }

    public function isEmpty(): bool
    {
        return $this->value === '';
    }
}

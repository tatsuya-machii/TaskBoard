<?php

namespace App\Domain\Task;

use App\Domain\Task\Exception\InvalidTaskId;
use Symfony\Component\Uid\Ulid;

/** タスクの識別子(値オブジェクト)。ULID を使用する。 */
final readonly class TaskId
{
    private function __construct(private string $value) {}

    public static function generate(): self
    {
        return new self(strtolower((string) new Ulid));
    }

    public static function fromString(string $value): self
    {
        if (! Ulid::isValid($value)) {
            throw InvalidTaskId::invalidFormat($value);
        }

        return new self(strtolower($value));
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}

<?php

namespace App\Domain\Task\Exception;

use InvalidArgumentException;

final class InvalidTaskId extends InvalidArgumentException
{
    public static function invalidFormat(string $value): self
    {
        return new self("不正なタスクIDです: {$value}");
    }
}

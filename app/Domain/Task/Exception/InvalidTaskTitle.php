<?php

namespace App\Domain\Task\Exception;

use InvalidArgumentException;

final class InvalidTaskTitle extends InvalidArgumentException
{
    public static function empty(): self
    {
        return new self('タイトルは必須です。');
    }

    public static function tooLong(int $max): self
    {
        return new self("タイトルは{$max}文字以内で入力してください。");
    }
}

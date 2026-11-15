<?php

namespace App\Domain\Task\Exception;

use InvalidArgumentException;

final class InvalidTaskDescription extends InvalidArgumentException
{
    public static function tooLong(int $max): self
    {
        return new self("説明は{$max}文字以内で入力してください。");
    }
}

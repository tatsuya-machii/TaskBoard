<?php

namespace App\Http\Requests;

use App\Domain\Task\TaskDescription;
use App\Domain\Task\TaskTitle;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:'.TaskTitle::MAX_LENGTH],
            'description' => ['nullable', 'string', 'max:'.TaskDescription::MAX_LENGTH],
        ];
    }

    public function attributes(): array
    {
        return ['title' => 'タイトル', 'description' => '説明'];
    }
}

<?php

namespace Tests\Unit\Domain\Task;

use App\Domain\Task\Exception\InvalidTaskDescription;
use App\Domain\Task\Exception\InvalidTaskId;
use App\Domain\Task\Exception\InvalidTaskTitle;
use App\Domain\Task\Task;
use App\Domain\Task\TaskDescription;
use App\Domain\Task\TaskId;
use App\Domain\Task\TaskStatus;
use App\Domain\Task\TaskTitle;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function test_タイトルは前後の空白を除去する(): void
    {
        $this->assertSame('買い物', TaskTitle::fromString("  買い物 \n")->value());
    }

    public function test_空のタイトルは拒否される(): void
    {
        $this->expectException(InvalidTaskTitle::class);
        TaskTitle::fromString('   ');
    }

    public function test_タイトルは100文字まで許容し超過は拒否する(): void
    {
        $this->assertSame(100, mb_strlen(TaskTitle::fromString(str_repeat('あ', 100))->value()));

        $this->expectException(InvalidTaskTitle::class);
        TaskTitle::fromString(str_repeat('あ', 101));
    }

    public function test_説明は空を許容し1000文字超過は拒否する(): void
    {
        $this->assertTrue(TaskDescription::empty()->isEmpty());

        $this->expectException(InvalidTaskDescription::class);
        TaskDescription::fromString(str_repeat('a', 1001));
    }

    public function test_タスク_i_dの生成と検証(): void
    {
        $id = TaskId::generate();
        $this->assertTrue($id->equals(TaskId::fromString($id->value())));

        $this->expectException(InvalidTaskId::class);
        TaskId::fromString('not-a-ulid');
    }

    public function test_新規タスクは_todoで始まる(): void
    {
        $task = $this->newTask();

        $this->assertSame(TaskStatus::Todo, $task->status());
    }

    public function test_編集でタイトル説明と更新日時が変わる(): void
    {
        $task = $this->newTask();
        $later = new DateTimeImmutable('2026-01-02 00:00:00');

        $task->edit(TaskTitle::fromString('新タイトル'), TaskDescription::fromString('詳細'), $later);

        $this->assertSame('新タイトル', $task->title()->value());
        $this->assertSame('詳細', $task->description()->value());
        $this->assertEquals($later, $task->updatedAt());
        $this->assertEquals(new DateTimeImmutable('2026-01-01 00:00:00'), $task->createdAt());
    }

    public function test_状態変更で更新日時が変わり同じ状態なら変わらない(): void
    {
        $task = $this->newTask();
        $later = new DateTimeImmutable('2026-01-02 00:00:00');

        $task->changeStatus(TaskStatus::Todo, $later);
        $this->assertEquals(new DateTimeImmutable('2026-01-01 00:00:00'), $task->updatedAt());

        $task->changeStatus(TaskStatus::Done, $later);
        $this->assertSame(TaskStatus::Done, $task->status());
        $this->assertEquals($later, $task->updatedAt());
    }

    public function test_ステータスの前後の列(): void
    {
        $this->assertSame(TaskStatus::InProgress, TaskStatus::Todo->next());
        $this->assertNull(TaskStatus::Done->next());
        $this->assertNull(TaskStatus::Todo->previous());
        $this->assertSame(TaskStatus::Todo, TaskStatus::InProgress->previous());
    }

    private function newTask(): Task
    {
        return Task::create(
            TaskId::generate(),
            TaskTitle::fromString('タイトル'),
            TaskDescription::empty(),
            new DateTimeImmutable('2026-01-01 00:00:00'),
        );
    }
}

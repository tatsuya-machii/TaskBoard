<?php

namespace Tests\Feature;

use App\Domain\Task\TaskId;
use App\Infrastructure\Persistence\EloquentTaskModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskBoardTest extends TestCase
{
    use RefreshDatabase;

    private function makeTask(string $title = 'テスト', string $status = 'todo'): EloquentTaskModel
    {
        return EloquentTaskModel::create([
            'id' => TaskId::generate()->value(),
            'title' => $title,
            'description' => null,
            'status' => $status,
        ]);
    }

    public function test_ダッシュボードにステータス別でタスクが表示される(): void
    {
        $this->makeTask('やること', 'todo');
        $this->makeTask('作業中', 'in_progress');
        $this->makeTask('終わった', 'done');

        $this->get('/')
            ->assertOk()
            ->assertSeeInOrder(['To Do', 'やること', '進行中', '作業中', '完了', '終わった']);
    }

    public function test_タスクを追加できる(): void
    {
        $this->post('/tasks', ['title' => '新規タスク', 'description' => '詳細'])
            ->assertRedirect('/');

        $this->assertDatabaseHas('tasks', ['title' => '新規タスク', 'description' => '詳細', 'status' => 'todo']);
    }

    public function test_タイトルが空だと追加できない(): void
    {
        $this->post('/tasks', ['title' => ''])->assertSessionHasErrors('title');
        $this->post('/tasks', ['title' => str_repeat('あ', 101)])->assertSessionHasErrors('title');

        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_タスクを編集できる(): void
    {
        $task = $this->makeTask('旧');

        $this->get("/tasks/{$task->id}/edit")->assertOk()->assertSee('旧');
        $this->put("/tasks/{$task->id}", ['title' => '新', 'description' => ''])->assertRedirect('/');

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => '新', 'description' => null]);
    }

    public function test_ステータスを変更できる(): void
    {
        $task = $this->makeTask();

        $this->patch("/tasks/{$task->id}/status", ['status' => 'done'])->assertRedirect('/');

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'done']);
    }

    public function test_不正なステータスは拒否される(): void
    {
        $task = $this->makeTask();

        $this->patch("/tasks/{$task->id}/status", ['status' => 'unknown'])->assertSessionHasErrors('status');
    }

    public function test_タスクを削除できる(): void
    {
        $task = $this->makeTask();

        $this->delete("/tasks/{$task->id}")->assertRedirect('/');

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_存在しないタスクや不正な_i_dは404(): void
    {
        $this->get('/tasks/'.TaskId::generate()->value().'/edit')->assertNotFound();
        $this->delete('/tasks/not-a-ulid')->assertNotFound();
    }
}

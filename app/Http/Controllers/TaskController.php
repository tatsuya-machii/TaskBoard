<?php

namespace App\Http\Controllers;

use App\Application\Task\ChangeTaskStatus;
use App\Application\Task\CreateTask;
use App\Application\Task\DeleteTask;
use App\Application\Task\GetTask;
use App\Application\Task\ListTasksForBoard;
use App\Application\Task\UpdateTask;
use App\Domain\Task\TaskStatus;
use App\Http\Requests\ChangeTaskStatusRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/** 薄いコントローラ。入力検証とユースケース呼び出し、画面遷移のみを担当する。 */
class TaskController extends Controller
{
    public function index(ListTasksForBoard $useCase): View
    {
        return view('board.index', [
            'board' => $useCase->handle(),
            'statuses' => TaskStatus::cases(),
        ]);
    }

    public function create(): View
    {
        return view('tasks.create');
    }

    public function store(StoreTaskRequest $request, CreateTask $useCase): RedirectResponse
    {
        $useCase->handle($request->validated('title'), $request->validated('description'));

        return redirect()->route('tasks.index')->with('status', 'タスクを追加しました。');
    }

    public function edit(string $id, GetTask $useCase): View
    {
        return view('tasks.edit', ['task' => $useCase->handle($id)]);
    }

    public function update(string $id, UpdateTaskRequest $request, UpdateTask $useCase): RedirectResponse
    {
        $useCase->handle($id, $request->validated('title'), $request->validated('description'));

        return redirect()->route('tasks.index')->with('status', 'タスクを更新しました。');
    }

    public function changeStatus(string $id, ChangeTaskStatusRequest $request, ChangeTaskStatus $useCase): RedirectResponse
    {
        $useCase->handle($id, TaskStatus::from($request->validated('status')));

        return redirect()->route('tasks.index')->with('status', 'ステータスを変更しました。');
    }

    public function destroy(string $id, DeleteTask $useCase): RedirectResponse
    {
        $useCase->handle($id);

        return redirect()->route('tasks.index')->with('status', 'タスクを削除しました。');
    }
}

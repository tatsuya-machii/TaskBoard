@extends('layouts.app')

@section('title', 'タスク編集 - TaskBoard')

@section('content')
    <h1 class="mb-4 text-lg font-semibold">タスクを編集</h1>
    <form method="POST" action="{{ route('tasks.update', $task->id) }}" class="max-w-xl rounded-lg bg-white p-6 shadow-sm">
        @method('PUT')
        @include('tasks._form', ['submit' => '更新する'])
    </form>
@endsection

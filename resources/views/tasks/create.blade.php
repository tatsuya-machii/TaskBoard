@extends('layouts.app')

@section('title', 'タスク追加 - TaskBoard')

@section('content')
    <h1 class="mb-4 text-lg font-semibold">タスクを追加</h1>
    <form method="POST" action="{{ route('tasks.store') }}" class="max-w-xl rounded-lg bg-white p-6 shadow-sm">
        @include('tasks._form', ['submit' => '追加する'])
    </form>
@endsection

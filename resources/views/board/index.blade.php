@extends('layouts.app')

@section('title', 'ダッシュボード - TaskBoard')

@section('content')
    <div class="grid gap-4 md:grid-cols-3">
        @foreach ($statuses as $status)
            @php $tasks = $board[$status->value]; @endphp
            <section class="rounded-lg bg-slate-200/60 p-3" aria-label="{{ $status->label() }}">
                <h2 class="mb-3 flex items-center justify-between px-1 font-semibold">
                    <span>{{ $status->label() }}</span>
                    <span class="rounded-full bg-white px-2 py-0.5 text-xs text-slate-600">{{ count($tasks) }}</span>
                </h2>

                <div class="space-y-3">
                    @forelse ($tasks as $task)
                        <article class="rounded-md bg-white p-3 shadow-sm">
                            <h3 class="font-medium break-words">{{ $task->title }}</h3>
                            @if ($task->description !== '')
                                <p class="mt-1 whitespace-pre-line text-sm text-slate-600 break-words">{{ $task->description }}</p>
                            @endif
                            <p class="mt-2 text-xs text-slate-400">更新: {{ $task->updatedAt }}</p>

                            <div class="mt-3 flex flex-wrap items-center gap-2 text-xs">
                                @if ($prev = $status->previous())
                                    <form method="POST" action="{{ route('tasks.status', $task->id) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $prev->value }}">
                                        <button class="rounded border border-slate-300 px-2 py-1 hover:bg-slate-50">← {{ $prev->label() }}</button>
                                    </form>
                                @endif
                                @if ($next = $status->next())
                                    <form method="POST" action="{{ route('tasks.status', $task->id) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $next->value }}">
                                        <button class="rounded border border-slate-300 px-2 py-1 hover:bg-slate-50">{{ $next->label() }} →</button>
                                    </form>
                                @endif

                                <a href="{{ route('tasks.edit', $task->id) }}" class="ml-auto text-indigo-600 hover:underline">編集</a>
                                <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" onsubmit="return confirm('このタスクを削除しますか?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">削除</button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <p class="px-1 py-4 text-center text-sm text-slate-400">タスクはありません</p>
                    @endforelse
                </div>
            </section>
        @endforeach
    </div>
@endsection

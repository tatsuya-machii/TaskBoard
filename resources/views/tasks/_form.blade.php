@csrf
<div class="space-y-4">
    <div>
        <label for="title" class="block text-sm font-medium">タイトル <span class="text-red-500">*</span></label>
        <input id="title" name="title" type="text" required maxlength="100"
               value="{{ old('title', $task->title ?? '') }}"
               class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:outline-none">
        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-medium">説明</label>
        <textarea id="description" name="description" rows="5" maxlength="1000"
                  class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:outline-none">{{ old('description', $task->description ?? '') }}</textarea>
        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center gap-3">
        <button class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">{{ $submit }}</button>
        <a href="{{ route('tasks.index') }}" class="text-sm text-slate-600 hover:underline">キャンセル</a>
    </div>
</div>

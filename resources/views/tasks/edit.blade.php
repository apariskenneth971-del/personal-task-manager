@extends('layouts.app')

@section('title', 'Edit Task — Personal Task Manager')

@section('content')
    <div class="form-card">
        <h2 style="margin-top:0; font-size:20px;">Edit Task</h2>
        <p style="color:var(--muted); margin-top:-8px; font-size:14px;">Update the details below.</p>

        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="task_name">Task Name</label>
                <input type="text" id="task_name" name="task_name" class="form-control"
                       value="{{ old('task_name', $task->task_name) }}" required>
                @error('task_name')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea id="description" name="description" class="form-control">{{ old('description', $task->description) }}</textarea>
                @error('description')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="due_date">Due Date</label>
                <input type="date" id="due_date" name="due_date" class="form-control"
                       value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                @error('due_date')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="Pending" {{ old('status', $task->status) === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Completed" {{ old('status', $task->status) === 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
                @error('status')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('tasks.index') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Task</button>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Add Task — Personal Task Manager')

@section('content')
    <div class="form-card">
        <h2 style="margin-top:0; font-size:20px;">Add a New Task</h2>
        <p style="color:var(--muted); margin-top:-8px; font-size:14px;">Fill in the details below.</p>

        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="task_name">Task Name</label>
                <input type="text" id="task_name" name="task_name" class="form-control"
                       value="{{ old('task_name') }}" placeholder="e.g. Finish Laravel project" required>
                @error('task_name')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea id="description" name="description" class="form-control"
                          placeholder="Add any details or notes about this task...">{{ old('description') }}</textarea>
                @error('description')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="due_date">Due Date</label>
                <input type="date" id="due_date" name="due_date" class="form-control" value="{{ old('due_date') }}">
                @error('due_date')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="Pending" {{ old('status', 'Pending') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Completed" {{ old('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
                @error('status')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('tasks.index') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Task</button>
            </div>
        </form>
    </div>
@endsection

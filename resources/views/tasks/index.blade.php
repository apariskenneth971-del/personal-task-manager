@extends('layouts.app')

@section('title', 'My Tasks — Personal Task Manager')

@section('content')

    <div class="stats-row">
        <div class="stat-card total">
            <div class="num">{{ $totalCount }}</div>
            <div class="label">Total Tasks</div>
        </div>
        <div class="stat-card pending">
            <div class="num">{{ $pendingCount }}</div>
            <div class="label">Pending</div>
        </div>
        <div class="stat-card completed">
            <div class="num">{{ $completedCount }}</div>
            <div class="label">Completed</div>
        </div>
    </div>

    <div class="toolbar">
        <div class="filters">
            <a href="{{ route('tasks.index') }}" class="chip {{ request('status') ? '' : 'active' }}">All</a>
            <a href="{{ route('tasks.index', ['status' => 'Pending']) }}" class="chip {{ request('status') === 'Pending' ? 'active' : '' }}">Pending</a>
            <a href="{{ route('tasks.index', ['status' => 'Completed']) }}" class="chip {{ request('status') === 'Completed' ? 'active' : '' }}">Completed</a>
        </div>
        <form method="GET" action="{{ route('tasks.index') }}" style="display:flex; gap:8px;">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks..." class="search-input">
            <button type="submit" class="btn btn-outline btn-sm">Search</button>
        </form>
    </div>

    @forelse($tasks as $task)
        <div class="task-card {{ $task->status === 'Completed' ? 'is-completed' : '' }} {{ $task->is_overdue ? 'is-overdue' : '' }}">
            <div class="task-main">
                <p class="task-title {{ $task->status === 'Completed' ? 'done' : '' }}">
                    {{ $task->task_name }}
                    <span class="badge-status {{ $task->status === 'Completed' ? 'badge-completed' : 'badge-pending' }}">
                        {{ $task->status }}
                    </span>
                </p>
                @if($task->description)
                    <p class="task-desc">{{ $task->description }}</p>
                @endif
                <div class="task-meta">
                    @if($task->due_date)
                        <span>📅 Due {{ $task->due_date->format('M d, Y') }}</span>
                    @else
                        <span>📅 No due date</span>
                    @endif
                    @if($task->is_overdue)
                        <span class="overdue-tag">⚠ Overdue</span>
                    @endif
                    <span>Created {{ $task->created_at->diffForHumans() }}</span>
                </div>
            </div>

            <div class="task-actions">
                <form class="status-toggle-form" method="POST" action="{{ route('tasks.updateStatus', $task) }}">
                    @csrf
                    @method('PATCH')
                    @if($task->status === 'Pending')
                        <input type="hidden" name="status" value="Completed">
                        <button type="submit" class="btn btn-success btn-sm">Mark Completed</button>
                    @else
                        <input type="hidden" name="status" value="Pending">
                        <button type="submit" class="btn btn-outline btn-sm">Mark Pending</button>
                    @endif
                </form>

                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline btn-sm">Edit</a>

                <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task? This cannot be undone.');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="icon">🗒️</div>
            <p><strong>No tasks found.</strong></p>
            <p>Try adjusting your filters, or add your first task to get started.</p>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary" style="margin-top:10px;">+ Add Task</a>
        </div>
    @endforelse

@endsection

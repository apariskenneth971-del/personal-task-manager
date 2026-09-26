<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks (with simple status filter + search).
     */
    public function index(Request $request): View
    {
        $query = Task::query();

        // Optional filter: ?status=Pending or ?status=Completed
        if ($request->filled('status') && in_array($request->status, ['Pending', 'Completed'])) {
            $query->where('status', $request->status);
        }

        // Optional search: ?search=keyword
        if ($request->filled('search')) {
            $query->where('task_name', 'like', '%'.$request->search.'%');
        }

        $tasks = $query->orderBy('due_date')->orderByDesc('created_at')->get();

        $totalCount = Task::count();
        $pendingCount = Task::pending()->count();
        $completedCount = Task::completed()->count();

        return view('tasks.index', compact('tasks', 'totalCount', 'pendingCount', 'completedCount'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create(): View
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateTask($request);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task added successfully.');
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $validated = $this->validateTask($request);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    /**
     * Quickly toggle / set a task's status (Pending <-> Completed).
     */
    public function updateStatus(Request $request, Task $task): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:Pending,Completed',
        ]);

        $task->update(['status' => $request->status]);

        return redirect()->route('tasks.index')->with('success', 'Task status updated.');
    }

    /**
     * Shared validation rules for store/update.
     */
    private function validateTask(Request $request): array
    {
        return $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Pending,Completed',
            'due_date' => 'nullable|date',
        ]);
    }
}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Personal Task Manager')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="app-shell">
        <header class="topbar">
            <a href="{{ route('tasks.index') }}" class="brand" style="text-decoration:none; color:inherit;">
                <div class="brand-mark">✓</div>
                <div>
                    <h1>Personal Task Manager</h1>
                    <p>Stay on top of what matters</p>
                </div>
            </a>
            @if(Route::currentRouteName() !== 'tasks.create')
                <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ Add Task</a>
            @else
                <a href="{{ route('tasks.index') }}" class="btn btn-outline">← Back to Tasks</a>
            @endif
        </header>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Please fix the following:</strong>
                <ul style="margin: 6px 0 0 18px; padding: 0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>

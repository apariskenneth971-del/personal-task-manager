# Personal Task Manager (Laravel)

Project Code: WST21-PM-2026-SF
Student Name: APARIS, KENNETH RHOY T.
Course & Year: BSIT 2nd year
Database Used: MySQL 

## Features
- Add Task
- View Tasks
- Edit Task
- Delete Task
- Update Status (Pending / Completed)

### Extra features included
- Dashboard stats (total / pending / completed counts)
- Filter tasks by status (All / Pending / Completed)
- Search tasks by name
- Overdue task indicator (highlighted in red when a Pending task's due date has passed)
- Clean, modern, responsive UI (custom CSS, no build step required)
- Form validation with inline error messages
- One-click status toggle button (no need to open the edit form)

## Tech Stack
- Laravel 11
- Blade templating
- Eloquent ORM
- MySQL (default) — PostgreSQL/Supabase also supported by simply changing `.env`

## Project Structure (MVC flow)
```
Routes (routes/web.php)
   → Controller (app/Http/Controllers/TaskController.php)
      → Model (app/Models/Task.php)
         → Database (database/migrations/..._create_tasks_table.php)
      → Blade Views (resources/views/tasks/*.blade.php)
```

## Database Schema — `tasks` table
| Field       | Type                          | Notes                     |
|-------------|-------------------------------|----------------------------|
| id          | bigint, auto-increment        | Primary key                |
| task_name   | string                        | Required                   |
| description | text, nullable                | Optional details           |
| status      | enum('Pending','Completed')   | Default: Pending           |
| due_date    | date, nullable                | Task deadline              |
| created_at  | timestamp                     | Auto-managed by Laravel    |
| updated_at  | timestamp                     | Auto-managed by Laravel    |

## Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd task-manager
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Set up environment file**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure your database** in `.env`
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=task_manager
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   Create the database first, e.g.:
   ```sql
   CREATE DATABASE task_manager;
   ```

   > Using PostgreSQL/Supabase instead? Just set `DB_CONNECTION=pgsql` and fill in
   > the matching `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
   > from your Supabase project settings — no code changes needed.

5. **Run the migrations**
   ```bash
   php artisan migrate
   ```

6. **Serve the application**
   ```bash
   php artisan serve
   ```
   Visit **http://127.0.0.1:8000** — it will redirect you straight to the task list.

## Routes

| Method | URI                  | Action                     | Route Name           |
|--------|----------------------|-----------------------------|-----------------------|
| GET    | /tasks               | List all tasks              | tasks.index           |
| GET    | /tasks/create         | Show "add task" form        | tasks.create          |
| POST   | /tasks               | Store a new task             | tasks.store           |
| GET    | /tasks/{task}/edit    | Show "edit task" form        | tasks.edit            |
| PUT    | /tasks/{task}         | Update a task                | tasks.update          |
| DELETE | /tasks/{task}         | Delete a task                 | tasks.destroy         |
| PATCH  | /tasks/{task}/status  | Update task status only      | tasks.updateStatus    |

## How It Works (short explanation)

- **Routes** (`routes/web.php`) map URLs to `TaskController` methods using
  `Route::resource()` for the standard CRUD actions, plus one extra `PATCH`
  route dedicated to toggling status.
- **Controller** (`TaskController`) validates incoming form data and talks to
  the `Task` model to read/write the database. It never touches SQL directly —
  everything goes through Eloquent.
- **Model** (`Task`) maps to the `tasks` table and defines which fields are
  mass-assignable, how `due_date` is cast to a Carbon date object, and a small
  `is_overdue` accessor used by the UI.
- **Database**: a single migration creates the `tasks` table described above.
- **Blade Views** (`resources/views/tasks/`) render the task list, the add
  form, and the edit form, all sharing one layout (`layouts/app.blade.php`)
  for a consistent look.

## Screenshots
_Add your screenshots here after running the project locally, e.g._
- Task list / dashboard
- Add Task form
- Edit Task form
- Status update in action

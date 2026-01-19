# Copilot Instructions for Student Portal

## Project Overview

**Student Portal** is a Laravel 12 web application for managing student records with course enrollment. It uses Pest for testing, Tailwind CSS for styling, and Vite as the build system.

## Key Architecture Patterns

### Models & Eloquent ORM
- **Student model** (`app/Models/Student.php`): Main entity with attributes `name`, `email`, `course`, `year`. Uses `HasFactory` for seeding.
- **Course model** (`app/Models/Course.php`): NOT a database model—static class providing course data as a lookup table. Key method: `Course::all()` returns code→fullName mapping.
  - Course codes are short names like `'BS Information Technology'`, displayed as full names `'Bachelor of Science in Information Technology'`
  - Always use `Course::all()` when displaying course names to users; use `Course::getList()` for validation rules

### Database Schema
- **students table** (`database/migrations/2026_01_08_000000_create_students_table.php`): 
  - `id`, `name`, `email` (unique), `course` (stores course code), `year` (1-4), `timestamps`
  - No foreign keys currently; course stored as string code

### Routes & Web Layer
Routes in `routes/web.php` handle both:
1. **Direct closures** for reading/displaying students (GET `/students`, `/students/create`)
2. **StudentController** methods for mutations (POST create, update, destroy via implicit binding)

**Pattern**: Use Route model binding when accessing single students: `Route::get('/students/{student}', ...)`

### Request Validation
- Student creation/update validates: `name` (required, max 255), `email` (required, unique except on update), `course`, `year` (1-4 integer)
- Always use unique validation for email; include student ID on updates: `'unique:students,email,' . $student->id`

## Development Workflows

### Setup
```bash
composer run setup  # Installs dependencies, generates .env, runs migrations, builds frontend
```

### Running the Application
```bash
composer run dev  # Runs PHP server (port 8000), queue listener, and Vite dev server concurrently
```

### Testing
```bash
php artisan test        # Run all tests (Pest)
php artisan test tests/Feature  # Run feature tests only
```

### Database
```bash
php artisan migrate         # Apply migrations
php artisan migrate:fresh   # Reset and apply migrations
php artisan tinker          # Interactive REPL for database queries
```

### Frontend Build
```bash
npm run dev    # Start Vite dev server (watches CSS/JS in resources/)
npm run build  # Production build
```

## Project-Specific Conventions

1. **Course handling**: Always reference the `Course` class when displaying or validating courses. Never hardcode course lists.
2. **Blade templates** in `resources/views/students/`: Use `{{ $student->course }}` but when displaying to users, map through `Course::all()` for full names.
3. **Testing setup**: Uses Pest 3.8+ with SQLite in-memory database for tests. Feature tests in `tests/Feature/`, unit tests in `tests/Unit/`.
4. **No authentication**: Currently no middleware or auth gates; routes are public.
5. **CSS/JS pipeline**: Uses Vite + Tailwind CSS 4. Entrypoints: `resources/css/app.css`, `resources/js/app.js`.

## Critical Integration Points

- **Controller ↔ Model**: StudentController uses Eloquent methods (`::all()`, `::create()`, `->update()`, `->delete()`).
- **View ↔ Controller**: Views receive data as compact arrays; ensure course mapping is done before passing to view.
- **Database ↔ Migrations**: Never modify `students` table directly; create new migrations for schema changes.
- **Frontend ↔ Backend**: Form submissions to `/students` (POST) must include CSRF token (auto-injected by Blade).

## Common Tasks

| Task | Command |
|------|---------|
| Add new student endpoint | Create route + method in StudentController |
| Add database field | Create migration with `php artisan make:migration` |
| Run tests | `php artisan test` or `vendor/bin/pest` |
| Format code | `php artisan pint` (Laravel formatting standard) |
| Debug query | Use `php artisan tinker` or `DB::enableQueryLog()` in controller |

## When Extending the App

- **New models**: Use `php artisan make:model ModelName -m` (includes migration).
- **New controllers**: Use `php artisan make:controller ControllerName --resource` for CRUD boilerplate.
- **Static data**: Follow `Course` pattern—don't use models for lookup tables.
- **Database relationships**: Add foreign keys in migrations; use Eloquent relations in models.

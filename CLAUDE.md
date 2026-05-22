# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Setup

**With Docker (recommended):**
```bash
cd docker
make up        # start containers
make setup     # composer install, copy .env, key:generate, migrate, npm install & build
```

**Without Docker:**
```bash
composer setup   # install deps, copy .env, generate key, migrate, npm install & build
```

## Development

**With Docker:**
```bash
cd docker
make up           # start all containers
make npm-dev      # run Vite dev server inside container
```

**Without Docker:**
```bash
composer dev     # starts all services concurrently: web server, queue worker, log viewer (pail), Vite
```

## Docker Makefile Commands

All commands run from the `docker/` folder. `COMPOSE_PROJECT_NAME` is derived from the root folder name, so container names are unique per clone.

```bash
make up                          # start containers (detached)
make down                        # stop containers
make restart                     # restart containers
make destroy                     # stop and remove containers, images, and orphans

make bash                        # shell into app container

make artisan args="route:list"   # run any artisan command
make migrate                     # php artisan migrate
make migrate-fresh               # migrate:fresh --seed

make composer args="install"     # run any composer command
make npm args="run build"        # run any npm command
make npm-build                   # npm run build
make npm-dev                     # npm run dev (Vite watch)
```

## Testing

```bash
composer test                          # clears config cache, then runs full test suite
php artisan test --filter=TestName     # run a single test or test class
php artisan test tests/Feature/ExampleTest.php  # run a specific file
```

Tests use SQLite in-memory (`DB_DATABASE=:memory:`), so no database setup is needed. Queue runs synchronously and cache/session use the array driver in tests.

## Code Style

```bash
./vendor/bin/pint        # fix code style (Laravel Pint / PSR-12-based)
./vendor/bin/pint --test # check without fixing
```

## Key Architecture Notes

- **Laravel 13 on PHP 8.4+** — uses the fluent `Application::configure()` bootstrap style in `bootstrap/app.php` instead of kernel classes.
- **Auth** — provided by Laravel Breeze (Blade stack). Controllers live in `app/Http/Controllers/Auth/`, views in `resources/views/auth/` and `resources/views/profile/`. Routes are in `routes/auth.php`, included automatically by Breeze via `routes/web.php`.
- **Layout components** — two anonymous component layouts: `AppLayout` (`layouts/app.blade.php`) wraps authenticated pages with the nav bar; `GuestLayout` (`layouts/guest.blade.php`) wraps auth forms (login, register, etc.). Use `<x-app-layout>` or `<x-guest-layout>` in views.
- **Frontend** — Vite with Bootstrap 5 (CSS via `bootstrap/dist/css/bootstrap.min.css`, JS bundle via `bootstrap/dist/js/bootstrap.bundle`) and Alpine.js. All views rely on `@vite()`, so `npm run build` must run before the app renders.
- **Database** — MySQL (`DB_HOST=mysql` service name for Docker, `DB_DATABASE=last_boiler`, `DB_USERNAME=laravel`, `DB_PASSWORD=secret`). Session, cache, and queue all default to the `database` driver — `migrate` must run before the app works. Three standard migrations exist: users, cache, and jobs tables.
- **Docker** — config in `docker/`. The PHP-FPM container includes Composer and Node.js. MySQL data persists in `docker/mysql/` (bind mount). Redis service name is `redis`.
- **No API routes** — only `routes/web.php`, `routes/auth.php`, and `routes/console.php` are registered. Add `api: __DIR__.'/../routes/api.php'` in `bootstrap/app.php` to enable API routing.
- **Service providers** — registered in `bootstrap/providers.php`, not `config/app.php` as in older Laravel versions.
- **Middleware and exception handling** — configured via closures directly in `bootstrap/app.php`, not in separate Kernel classes.
- **Health check** — a `/up` endpoint is registered automatically via `bootstrap/app.php`.

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

All commands run from the `docker/` folder. Container names are prefixed with the project root folder name automatically.

```bash
make up                          # start containers (detached)
make down                        # stop containers
make bash                        # shell into app container

make artisan args="route:list"   # run any artisan command
make migrate                     # php artisan migrate
make migrate-fresh               # migrate:fresh --seed

make composer args="install"     # run any composer command
make npm args="run build"        # run any npm command
make npm-build                   # npm run build
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

- **Laravel 13 on PHP 8.3+** — uses the fluent `Application::configure()` bootstrap style in `bootstrap/app.php` instead of kernel classes.
- **Auth** — provided by Laravel Breeze (Blade stack). Views live in `resources/views/auth/` and `resources/views/profile/`. Routes are in `routes/auth.php`, included automatically by Breeze.
- **Database** — MySQL (`DB_HOST=mysql` service name for Docker, `DB_DATABASE=last_boiler`, `DB_USERNAME=laravel`, `DB_PASSWORD=secret`). Session, cache, and queue all default to the `database` driver — `migrate` must run before the app works.
- **Frontend** — Vite with Tailwind CSS v4 (via `@tailwindcss/vite`) and Alpine.js. `tailwindcss` v4 must be present at the top level to avoid conflict with `@tailwindcss/forms`. PostCSS config is intentionally absent (not needed in v4).
- **Docker** — config in `docker/`. The PHP-FPM container includes Composer and Node.js. MySQL data persists in `docker/mysql/` (bind mount). Redis service name is `redis`.
- **No API routes** — only `routes/web.php`, `routes/auth.php`, and `routes/console.php` are registered. Add `api: __DIR__.'/../routes/api.php'` in `bootstrap/app.php` to enable API routing.
- **Middleware and exception handling** — configured via closures directly in `bootstrap/app.php`, not in separate Kernel classes.

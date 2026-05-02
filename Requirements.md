# Requirements

## Authentication

Implemented via **Laravel Breeze (Blade stack)**. Includes:

- Register
- Login / Logout
- Password reset (forgot password flow)
- Email verification
- Profile page (update name, email, password)

## Frontend

- **Blade** templates only
- **Tailwind CSS v4** compiled via **Vite** — NPM is required
- No JavaScript framework
- `npm run build` must be run before the app renders correctly (all views use `@vite()`)

## API

No additional API setup. Laravel's default routing is sufficient; consumers of this boilerplate can add API routes themselves.

## Multi-tenancy

Single tenant only.

## Additional Modules

None beyond what Laravel and Breeze provide out of the box.

## Dev Tooling

- **PHPUnit** for testing
- **Laravel Pint** for code style

## Docker

Configuration lives in a separate `docker/` folder. `docker-compose.yml` includes:

- **PHP-FPM** (app container) — also includes **Composer** and **Node.js / NPM** for running dependency installs and Vite builds inside the container
- **Nginx** (web server)
- **MySQL** (database) — data is persisted via a bind mount to `docker/mysql/` so it survives container rebuilds. Hardcoded credentials in `docker-compose.yml` (`DB_DATABASE=last_boiler`, `DB_USERNAME=laravel`, `DB_PASSWORD=secret`) must match the values in `.env.example`
- **Redis** (cache / queue)

The `docker-compose.yml` project name is derived automatically from the project root folder name (via `COMPOSE_PROJECT_NAME` in the Makefile), so container names are unique per project and never conflict across different boilerplate instances.

A **Makefile** in the `docker/` folder provides shortcuts for common operations, including:

- Starting and stopping containers
- Running Laravel commands inside the app container (e.g. `artisan`, `composer`, `migrate`)
- Running NPM commands inside the app container (e.g. `npm install`, `npm run build`)

## CI/CD

None.

## Deployment

No specific deployment target.

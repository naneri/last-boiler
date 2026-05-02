# Laravel Boilerplate

A Laravel 13 starter kit with authentication, Docker, and a minimal Blade + Tailwind CSS frontend.

**Includes out of the box:**
- Auth via Laravel Breeze: register, login, logout, password reset, email verification, profile page
- Docker setup: PHP-FPM (with Composer + Node.js), Nginx, MySQL 8, Redis
- Tailwind CSS v4 + Alpine.js via Vite

---

## Setup

**1. Clone the repo and go into the project folder:**

```bash
git clone <repo-url> my-app
cd my-app
```

**2. Start the containers:**

```bash
cd docker
make up
```

**3. Run the first-time setup** (installs dependencies, sets up `.env`, runs migrations, builds assets):

```bash
make setup
```

The app is now running at **http://localhost:8000**.

---

## Daily Use

All `make` commands are run from the `docker/` folder.

| Command | Description |
|---|---|
| `make up` | Start containers |
| `make down` | Stop containers |
| `make restart` | Restart containers |
| `make bash` | Open a shell inside the app container |
| `make migrate` | Run migrations |
| `make migrate-fresh` | Drop all tables, re-migrate, and seed |
| `make artisan args="..."` | Run any Artisan command |
| `make composer args="..."` | Run any Composer command |
| `make npm args="..."` | Run any npm command |
| `make npm-build` | Build frontend assets |

**Examples:**

```bash
make artisan args="make:controller PostController"
make artisan args="route:list"
make composer args="require spatie/laravel-permission"
make npm args="install my-package"
```

---

## Environment

The `.env` file is created automatically during `make setup` from `.env.example`. The default values match the Docker services and require no changes to get started.

| Variable | Default | Notes |
|---|---|---|
| `DB_HOST` | `mysql` | Docker service name |
| `DB_DATABASE` | `last_boiler` | |
| `DB_USERNAME` | `laravel` | |
| `DB_PASSWORD` | `secret` | |
| `REDIS_HOST` | `redis` | Docker service name |

---

## Running Tests

Tests use an in-memory SQLite database and do not require Docker to be running.

```bash
# From the project root (with PHP available locally)
composer test

# Or from inside the container
make bash
php artisan test
```

---

## Database Persistence

MySQL data is stored in `docker/mysql/` via a bind mount. Destroying and recreating the MySQL container will not lose data. To reset the database, run `make migrate-fresh` or delete the contents of `docker/mysql/`.

---

## Code Style

```bash
# From inside the container
make bash
./vendor/bin/pint
```

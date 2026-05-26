# Implementation Plan - Performance Optimization (Docker/Laravel/PHP)

Auditing and optimizing the current Docker infrastructure and Laravel runtime to improve response times, stability, and bootstrap efficiency on Windows (Docker Desktop).

## User Review Required

> [!IMPORTANT]
> **Switching to Nginx + PHP-FPM**: The current setup uses `php artisan serve` which is single-threaded and not suitable for performance. I will move to a standard Nginx + PHP-FPM architecture.
> **APP_DEBUG**: I will set `APP_DEBUG=false` in the Docker environment by default to stabilize local navigation, as requested.
> **Installation of Tools**: I will install `nunomaduro/larastan` and configure `laravel/pint` to ensure code quality and style consistency.
> **Git Hooks Activation**: I will configure a script to automatically link the hooks from `.githooks/` to `.git/hooks/`.
> **Environment Sync**: I will synchronize `.env` and `.env.example` to ensure they share the same structure and essential keys.
> **Container Restart**: These changes will require a full rebuild and restart of the Docker containers.

## Proposed Changes

### Configuration & Infrastructure
#### [NEW] [docker/php/php.ini](file:///c:/Projetos/calculadora-rescisao-laravel/docker/php/php.ini)
- Enable and tune **Opcache** (memory, max_accelerated_files, validate_timestamps).
- Optimize **realpath_cache** for Windows mount performance.
- Tune memory limits and execution times.

#### [NEW] [docker/php/fpm-performance.conf](file:///c:/Projetos/calculadora-rescisao-laravel/docker/php/fpm-performance.conf)
- Optimize PHP-FPM pool settings (`pm = dynamic`, `max_children`, `max_requests`).
- Configure health checks for the upstream.

#### [NEW] [docker/nginx/default.conf](file:///c:/Projetos/calculadora-rescisao-laravel/docker/nginx/default.conf)
- Configure Nginx as a reverse proxy for PHP-FPM.
- Optimize for static file serving.
- Prevent 502 errors during container restarts using a dynamic resolver.

#### [NEW] [docker/scripts/start-app.sh](file:///c:/Projetos/calculadora-rescisao-laravel/docker/scripts/start-app.sh)
- Wait for the database to be ready.
- Conditionally run migrations.
- Warm up caches (`config:cache`, `route:cache`, `view:cache`).
- Start PHP-FPM.

### Docker Environment
#### [MODIFY] [Dockerfile](file:///c:/Projetos/calculadora-rescisao-laravel/Dockerfile)
- Switch base image to `php:8.3-fpm-alpine`.
- Install and enable `opcache`.
- Copy custom PHP and FPM configurations.
- Use `start-app.sh` as the entrypoint.

#### [MODIFY] [docker-compose.yml](file:///c:/Projetos/calculadora-rescisao-laravel/docker-compose.yml)
- Update `app` service to use FPM.
- Add an `nginx` service.
- Optimize volume mounts for Windows.

### Application & Tooling
#### [MODIFY] [composer.json](file:///c:/Projetos/calculadora-rescisao-laravel/composer.json)
- Add `nunomaduro/larastan` as a dev dependency.
- Add `lint` and `analyse` commands to the `scripts` section.
- Add a `post-install-cmd` to activate git hooks.

#### [NEW] [phpstan.neon](file:///c:/Projetos/calculadora-rescisao-laravel/phpstan.neon)
- Configure PHPStan for Laravel with appropriate levels and paths.

#### [MODIFY] [.env.example](file:///c:/Projetos/calculadora-rescisao-laravel/.env.example)
- Synchronize with `.env` structure, using descriptive placeholders for keys/passwords.

#### [MODIFY] [run_commits.sh](file:///c:/Projetos/calculadora-rescisao-laravel/run_commits.sh)
- Ensure the script correctly assists with structured/conventional commits.

## Open Questions

- Would you like to keep `APP_DEBUG=true` even during this performance audit, or should I toggle it to `false` as suggested in the prompt for "real-world" behavior?
- Are there any specific routes that are currently slow that you'd like me to focus on first?

## Verification Plan

### Automated Tests
- Run `php artisan about` to verify cache status.
- Check `php -i | grep opcache` to ensure Opcache is active.
- Monitor `docker logs app_calculadora` and `docker logs nginx_calculadora`.

### Manual Verification
- Test `/login` and `/` response times using browser dev tools or `curl`.
- verify "cold start" behavior vs "warmed up" performance.

# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## About

Pixel Home is a Laravel 12 (PHP 8.2+) web app that acts as a data-collection and dashboard UI for Shelly
IoT devices (smart plugs/sensors). Devices push sensor readings over HTTP; the app stores them and renders
graphs/dashboards. It is a work in progress, single-maintainer project.

## Commands

### Local development (Laravel Sail)
Local dev runs entirely in Docker via [Laravel Sail](https://laravel.com/docs/sail) — **run all PHP,
Composer, and Artisan commands through `vendor/bin/sail`, never against a host PHP/Composer install.** The
`Makefile` wraps the common ones:

- `make start` (`vendor/bin/sail up -d`) — start the containers (PHP 8.4 app, MySQL 8.4, Mailhog)
- `make stop` (`vendor/bin/sail stop`) — stop them
- `make composer-install` (`vendor/bin/sail composer install`) — install PHP deps inside the container
- `make tests` (`vendor/bin/sail artisan test`) — run the full test suite
- `make pint` / `make pint-test` (`vendor/bin/sail shell -c 'vendor/bin/pint [--test]'`) — fix/check code
  style against the `laravel` StyleCI preset (`.styleci.yml`)
- `make help` — list all targets

For anything not wrapped by the `Makefile`, prefix it the same way, e.g.:
- `vendor/bin/sail artisan <command>` (migrate, tinker, etc.)
- `vendor/bin/sail artisan test tests/Feature/DeviceControllerTest.php` — run a single test file
- `vendor/bin/sail artisan test --filter testMethodName` — run a single test method
- `vendor/bin/sail composer <command>` for any other Composer command

The container config lives in `docker-compose.yml` and `docker/8.4/Dockerfile`. The Dockerfile's base image
and its third-party APT repos (ondrej/php PPA, NodeSource, pgdg) must stay on the same Ubuntu codename —
they're currently pinned to `noble` (24.04); don't bump `FROM ubuntu:...` without updating those to match,
or `apt-get install` will fail with unsatisfiable dependencies (packages built for one Ubuntu release won't
resolve against another release's library versions).

### Frontend assets
There is no npm/Node toolchain in this project — all frontend assets (AdminLTE/FontAwesome/jQuery/Bootstrap)
are pre-built, vendored files checked into `resources/css`, `resources/js`, and `resources/plugins`. They're
staged into `public/` by `tools/build-assets.php`, a plain PHP copy script wired into `composer.json` as the
`post-install-cmd`/`post-update-cmd` hooks — so `composer install`/`composer update` refreshes `public/`
automatically. Run it manually with `composer build-assets` if you edit a vendored asset without touching
`composer.json`. There is no compilation/bundling step, since no app-specific JS/CSS is built from source.

### CI vs. local
- CI (`.github/workflows/tests.yml`) runs PHPUnit directly on the host (no Sail/Docker) against SQLite
  (`DB_CONNECTION=sqlite`, `database/database.sqlite`) on PHP 8.2 — Sail's containers are a local-dev
  convenience, not what CI uses.
- Deployment is a bare `tools/deploy.sh` script (clones repo into `releases/<name>`, runs `composer install`
  which triggers the asset-copy hook, strips dev-only files, symlinks shared `.env`/`storage`, and re-points
  a `current` symlink) — not CI/CD-driven.

## Architecture

### Domain model
Four Eloquent models capture the whole domain (`app/Models`):
- **Device** (`devices` table): a physical Shelly device. Has a public `code` ("hash code to publish") used
  to authorize inbound pushes, an `active` flag, and soft deletes. `sensors()` is a `belongsToMany` via the
  `device_sensor` pivot table (see below); `points()` is a `hasMany`.
- **Sensor** (`sensors` table): a measurement type (e.g. temperature/humidity) with `unit`/`unit_symbol` and
  an `active` flag. `devices()` is the inverse `belongsToMany`; `points()` is a `hasMany`.
- **Point** (`points` table): a single timestamped reading (`value`, `added_on`), belonging to both a
  `Device` and a `Sensor`. No `timestamps`; `added_on` is cast to `immutable_datetime`.
- The **`device_sensor` pivot** table is not just a join table — it also carries a `chart_type` column
  (default `LineSeries`) that determines how a given device+sensor pairing is rendered in `GraphController`.
  When attaching a sensor to a device, be aware the pivot row may need `chart_type` considered too.

### Ingestion flow (unauthenticated)
`GET /point/push/{code}/{deviceId}/{sensorId}?value=X` (`PointController::push`, route named `point.push`)
is the only unauthenticated write path — this is the endpoint Shelly devices/scripts call to report sensor
values. It manually validates, in order: `value` present, sensor `active` and matches `sensorId`, device
`active`+`code`+`id` all match, and the device is actually linked to that sensor via the pivot — aborting
401 on any mismatch. There's no route model binding or form request here by design since the caller is an
external device, not an authenticated browser session.

### Authenticated app
Everything else lives behind the `auth` middleware group in `routes/web.php`:
- `DashboardController` — landing page after login.
- `DeviceController` / `SensorController` — CRUD for devices and sensors (Blade views under
  `resources/views/partials/device` and `partials/sensor`).
- `GraphController` (`/graph/show`) — reads `Point` rows filtered by device/sensor/date range, computes
  min/avg/max, converts `added_on` to the logged-in user's `timezone` (a column on `User`, set at
  registration/profile), and passes JSON data + the pivot's `chart_type` to the chart view.
- `PointController::index` (`/data-points/list`) — paginated table view of raw points with device/sensor
  filters.
- Auth scaffolding under `app/Http/Controllers/Auth` is Laravel Breeze-generated (controllers + `routes/auth.php`).

### Frontend
Server-rendered Blade views (`resources/views`) styled with a vendored **AdminLTE** build (assets checked
into `resources/plugins` and `resources/css`/`resources/js`, copied — not compiled — into `public/` by
`tools/build-assets.php`, see above). There's no SPA build step; treat this as a classic server-rendered app
with light client-side scripting (jQuery/Bootstrap bundled with AdminLTE).

### Tests
`tests/Feature` covers controllers end-to-end (HTTP + DB assertions); `tests/Unit` is sparse (only
`SensorTest.php`). Model factories exist for all four domain models plus `User` under `database/factories`.
When adding coverage for a new controller/endpoint, follow the existing `Feature` test structure rather than
introducing a new testing style.
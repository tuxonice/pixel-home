# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## About

Pixel Home is a Laravel 12 (PHP 8.2+) web app that acts as a data-collection and dashboard UI for Shelly
IoT devices (smart plugs/sensors). Devices push sensor readings over HTTP; the app stores them and renders
graphs/dashboards. It is a work in progress, single-maintainer project.

## Commands

### PHP / backend
- Install deps: `composer install`
- Run all tests: `vendor/bin/phpunit`
- Run a single test file: `vendor/bin/phpunit tests/Feature/DeviceControllerTest.php`
- Run a single test method: `vendor/bin/phpunit --filter testMethodName`
- Artisan: `php artisan <command>` (e.g. `php artisan migrate`, `php artisan tinker`)
- Code style: the project follows the `laravel` StyleCI preset (`.styleci.yml`); no local linter script is
  configured, so match existing formatting conventions when editing.

### JS / frontend assets
- Install deps: `npm install`
- Dev build: `npm run dev` (alias for `npm run development`, runs Laravel Mix)
- Watch mode: `npm run watch` (or `npm run watch-poll` in environments without file-change events, or
  `npm run hot` for hot reload)
- Production build: `npm run prod`

There is no frontend test suite or bundler beyond Laravel Mix — `webpack.mix.js` only copies vendored
AdminLTE/FontAwesome/jQuery/Bootstrap assets into `public/`; it does not compile app-specific JS/CSS.

### Local environment
- The project ships a `docker-compose.yml` modeled on Laravel Sail (PHP 8.4 container in `docker/8.4`,
  MySQL 8.4, Mailhog) — bring it up with `docker compose up` (env vars `WWWGROUP`/`WWWUSER`/`APP_PORT`/etc.
  come from `.env`).
- CI (`.github/workflows/tests.yml`) runs PHPUnit against SQLite (`DB_CONNECTION=sqlite`,
  `database/database.sqlite`) on PHP 8.2 — this is the fastest way to run tests locally too if you don't
  want to spin up MySQL.
- Deployment is a bare `tools/deploy.sh` script (clones repo into `releases/<name>`, builds assets, strips
  dev-only files, symlinks shared `.env`/`storage`, and re-points a `current` symlink) — not CI/CD-driven.

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
`webpack.mix.js`). Alpine.js and Axios are available as devDependencies but there's no SPA build step;
treat this as a classic server-rendered app with light client-side scripting.

### Tests
`tests/Feature` covers controllers end-to-end (HTTP + DB assertions); `tests/Unit` is sparse (only
`SensorTest.php`). Model factories exist for all four domain models plus `User` under `database/factories`.
When adding coverage for a new controller/endpoint, follow the existing `Feature` test structure rather than
introducing a new testing style.
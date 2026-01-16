<h1 align="center">VisitTrack</h1>

<p align="center">A Laravel-based visitor and appointment tracking system for buildings and facilities.</p>

---

## Overview

VisitTrack centralizes visitor management: create and manage appointments, track visits and locations, associate visitors with buildings and addresses, and generate QR codes for fast check-ins. It includes admin dashboard capabilities and notifications (e.g., GPS status) to keep operations smooth.

Key domain entities:

- Users and Credentials
- Addresses and Buildings
- Appointments and Visits
- QR Codes and Locations
- Activity Logs and Notifications

Built with Laravel, Vite, and MySQL/MariaDB.

## Features

- Appointment scheduling and updates
- Visitor check-in/out and visit history
- Building and address registry
- QR code generation and scanning support
- GPS status notifications
- Admin dashboard (migrations included)
- Activity logging

## Tech Stack

- Backend: Laravel (PHP)
- Database: MySQL/MariaDB
- Frontend assets: Vite (Node.js)
- Package management: Composer (PHP), npm (JS)

## Prerequisites

- PHP 8.x (CLI) and required extensions
- Composer
- Node.js 18+ and npm
- MySQL/MariaDB (XAMPP on Windows recommended)

## Quick Start (Windows/XAMPP)

1. Place the project under `C:\xampp\htdocs\visitrack`.
2. Create a database (e.g., `visitrack`) in phpMyAdmin or MySQL.
3. Create an environment file and app key:

```bash
copy .env.example .env
php artisan key:generate
```

4. Install dependencies:

```bash
composer install
npm install
```

5. Configure `.env` for your database and app URL.
6. Run migrations and (optionally) seed sample data:

```bash
php artisan migrate
php artisan db:seed
```

7. Start the development servers:

```bash
php artisan serve
npm run dev
```

Open `http://localhost:8000` (or your configured Apache vhost) to access the app.

## Configuration

Edit `.env` to match your environment. Common settings:

```env
# App
APP_NAME=VisitTrack
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

# Database (XAMPP defaults shown)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=visitrack
DB_USERNAME=root
DB_PASSWORD=

# Cache/Session/Queue
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=database

# Mail (optional)
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="VisitTrack"
```

After changes, you may optimize config and routes for production:

```bash
php artisan config:cache
php artisan route:cache
```

## Database

Migrations define tables for appointments, addresses, buildings, sessions, cache, and admin dashboard, among others. Seeders (e.g., `AddressSeeder`) can populate baseline data.

Useful commands:

```bash
php artisan migrate          # apply migrations
php artisan migrate:fresh    # drop and re-create schema
php artisan db:seed          # run DatabaseSeeder
```

## Development

- Laravel dev server: `php artisan serve`
- Vite dev server with HMR: `npm run dev`
- Build production assets: `npm run build`

If using Apache with XAMPP, point DocumentRoot to `public/` and ensure `.htaccess` is enabled for pretty URLs.

## Testing

Run the test suite with PHPUnit or the artisan wrapper:

```bash
php artisan test
```

Or directly:

```bash
vendor\bin\phpunit
```

## Project Structure

- `app/` — Application code (controllers, models, requests, notifications, providers)
	- `Http/Controllers/` — Feature controllers (e.g., appointments)
	- `Models/` — Domain models (appointment, visit, building, address, credential, user, location, qrCode)
	- `Notifications/` — e.g., `GpsStatusNotification`
- `bootstrap/` — Framework bootstrap
- `config/` — App configuration (auth, cache, database, filesystems, logging, mail, queue, services, session)
- `database/` — Factories, migrations, and seeders
- `public/` — Web entry (`index.php`), public assets
- `resources/` — Blade views, CSS/JS source (built via Vite)
- `routes/` — Route definitions (`web.php`, `console.php`)
- `storage/` — Logs, cache, compiled views, app files
- `vendor/` — Composer dependencies

## Common Commands

```bash
php artisan route:list        # inspect routes
php artisan make:model Foo -m # generate model + migration
php artisan make:controller   # generate controller
php artisan storage:link      # link storage/app/public
php artisan queue:work        # run queued jobs
php artisan schedule:run      # run scheduled tasks
```

## Deployment

1. Set `APP_ENV=production` and `APP_DEBUG=false`.
2. Configure your web server to serve the `public/` directory.
3. Run database migrations: `php artisan migrate`.
4. Build assets: `npm ci && npm run build`.
5. Optimize caches: `php artisan optimize`.
6. Configure queues (`QUEUE_CONNECTION=database` or `redis`) and supervisors.

## Troubleshooting

- 404s on pretty URLs: enable Apache `mod_rewrite`, ensure `.htaccess` is active and DocumentRoot points to `public/`.
- `.env` not loading: verify file exists at project root and correct permissions.
- Class/extension errors: ensure PHP extensions required by Laravel and MySQL are enabled in XAMPP.
- Asset issues: re-run `npm run dev` or `npm run build` and clear caches (`php artisan view:clear`, `php artisan cache:clear`).

## Acknowledgements

This application is built on the Laravel framework and uses community packages (e.g., QR code generation). See `composer.json` for a full dependency list.


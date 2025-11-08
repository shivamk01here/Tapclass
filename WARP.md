# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Common commands

Setup

- Composer deps: `composer install`
- Env: `copy .env.example .env` (PowerShell) then `php artisan key:generate`
- Node deps: `npm install`
- Database: `php artisan migrate`

Run (two terminals)

- Laravel HTTP server: `php artisan serve`
- Vite dev (assets, HMR): `npm run dev`

Build assets

- `npm run build`

Tests (PHPUnit via Laravel)

- All tests: `php artisan test`
- Single file: `php artisan test tests/Feature/ExampleTest.php`
- Filter by test name: `php artisan test --filter=Booking`
- PHPUnit directly (alternative): `./vendor/bin/phpunit --filter Booking tests/Feature/ExampleTest.php`

Lint/format (PHP)

- Check only: `./vendor/bin/pint --test`
- Fix: `./vendor/bin/pint`

DB maintenance

- Fresh schema: `php artisan migrate:fresh`
- Clear caches: `php artisan config:clear && php artisan cache:clear && php artisan route:clear`

## Architecture overview

Frameworks & tooling

- Backend: Laravel 10 (PHP ^8.1), Sanctum (API auth), Socialite (Google OAuth)
- Frontend assets: Vite + `laravel-vite-plugin` bundling `resources/css/app.css` and `resources/js/app.js`
- Views: Blade templates under `resources/views` with layouts for public, student, tutor, and admin
- Tests: PHPUnit with suites under `tests/Unit` and `tests/Feature` (coverage targets `app/`)

Routing and middleware

- Routes defined in `routes/web.php` and organized by role:
  - Public: home, static pages, tutor search/profile, auth
  - Student: prefixed `student/`, guarded by `auth` and `role:student`
  - Tutor: prefixed `tutor/`, guarded by `auth` and `role:tutor`; sensitive areas nested under `verified.tutor`
  - Admin: prefixed `admin/`, guarded by `auth` and `role:admin`
  - Shared messaging routes under `auth`
- Middleware aliases in `app/Http/Kernel.php`:
  - `role` → `App\Http\Middleware\RoleMiddleware` (strict role match)
  - `verified.tutor` → `App\Http\Middleware\VerifiedTutorMiddleware` (requires tutor role and `tutor_profiles.verification_status = 'verified'`)

Core domains and models (Eloquent)

- User (`app/Models/User.php`): roles `student|tutor|admin`; relations to `StudentProfile`, `TutorProfile`, `Wallet`, messages, notifications, likes, reviews, and bookings (as student/tutor)
- TutorProfile: belongs to `User`; subjects via pivot `tutor_subjects` (rates, availability flags); availability, reviews, likes, bookings, earnings; verification status helpers
- StudentProfile: belongs to `User`; `subjects_of_interest` stored as array
- Booking: belongs to student and tutor (`User`), and `Subject`; has one `Review` and one `TutorEarning`; fields for session timing, mode, pricing, commission, status, and optional `meet_link`
- Additional referenced models: `Wallet`, `WalletTransaction`, `TutorEarning`, `TutorAvailability`, `Subject`, `TutorSubject`, `Review`, `Message`, `Notification`, `SiteSetting`, `WithdrawalRequest`

Key application flows

- Authentication & onboarding (`App\Http\Controllers\AuthController`)
  - Email/password login and role-based redirects (student/tutor/admin)
  - Student registration creates `User(role=student)`, `StudentProfile`, and a funded `Wallet`
  - Tutor registration creates `User(role=tutor)`, `TutorProfile` (documents uploaded), and `TutorSubject` entries; profile starts `pending`
  - Google OAuth via Socialite (`/auth/google` and callback); configure provider in `config/services.php` and `.env`

- Tutor verification gating
  - `VerifiedTutorMiddleware` restricts tutor bookings/earnings/availability until `TutorProfile.verification_status === 'verified'`

- Tutor discovery & profiles
  - `HomeController` and `StudentController` expose tutor search (filters: subject, mode, rating) and public/tutor-facing profile pages

- Booking lifecycle (`App\Http\Controllers\BookingController`)
  - Creates booking with generated `booking_code` (e.g., `BKYYYYMMDDnnn`), validates time conflicts, derives hourly rates from `tutor_subjects` based on mode, calculates commission (`SiteSetting('commission_percentage')`, default 15%), and debits student `Wallet`
  - On cancel (by student or tutor): updates status, refunds to wallet, and cleans up pending `TutorEarning`
  - Reschedule endpoint is stubbed for future implementation

- Reviews, likes, and messaging
  - Students can review tutors for completed sessions, like/unlike tutors (updates counters), and use authenticated messaging endpoints (`MessageController`)

- Admin surface (`routes/web.php` → `AdminController`)
  - Tutor verification actions (approve/reject/ban), student wallet adjustments, bookings overview, payouts approval, site settings, and analytics

Frontend/views structure (high level)

- Layouts per role: `resources/views/layouts/{public,student,tutor,admin}.blade.php`
- Student: dashboard, tutor search and profiles, bookings (upcoming/past/cancelled), wallet, notifications, wishlist, settings, modern booking UI (`student/booking-create-modern.blade.php`)
- Tutor: dashboard, onboarding, bookings (pending/upcoming/past/cancelled with state changes), earnings, availability, reviews, notifications, profile
- Admin: dashboard, tutors, tutor verification, students, bookings, payouts, settings, analytics

## Notes that affect development

- Role-based access is enforced both at the route level (middleware) and inside controllers (ownership checks on `Booking` operations). Maintain these checks when adding endpoints.
- Wallet and earnings side effects are wrapped in DB transactions within booking flows; extend these patterns for related financial operations.  `php artisan serve` during development.

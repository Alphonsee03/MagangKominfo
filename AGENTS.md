# Cashify POS — Agent Guide

## Stack
- **Laravel 11** / PHP 8.2+ / MySQL 8.4
- **Tailwind v3** + custom JS plugins (`tailwind_plugins/`) + **Vite**
- **mpdf/mpdf v8.2** for PDF invoices (thermal 100×200mm for kasir)
- **chart.js** for dashboard charts
- **doctrine/dbal** in prod deps (needed for some column-type migrations)

## Dev Environment
- **Laravel Sail** (Docker) — `compose.yaml` at root. Run everything through `sail`:
  - `sail up -d` — start
  - `sail down` — stop
  - `sail artisan <cmd>` — Artisan
  - `sail test` — PHPUnit
  - `sail composer <cmd>`
  - `sail npm run dev` — Vite dev server (hot reload on port 5173)
  - `sail npm run build` — production build
- Sail runs PHP 8.5 runtime (`vendor/laravel/sail/runtimes/8.5`)

## Auth — Custom Multi-Guard
Single `users` table with `role` enum (`admin|kasir|supplier`). Three guards (`admin`, `kasir`, `supplier`) all point to the same `User` model. Middleware checks guard name for redirect logic. Supplier routes are referenced in config but **not yet defined** in `routes/web.php`.

## Non-Standard Config
- **Timezone**: `Asia/Jakarta` (`config/app.php`)
- **Session/Cache/Queue all use `database` driver** (not file/redis)
- `.env` exists but **no `.env.example`**

## Key Packages / Gotchas
| Package | Purpose |
|---------|---------|
| `mpdf/mpdf` | All PDF output (invoices, reports, stock/profit) |
| `doctrine/dbal` | Required for column-type-altering migrations |

- `resources/views/layouts/admin-layout.blade.php` **exists but is empty** — do not rely on it.
- Session-based cart lives in `CartController` (kasir side).
- `InvoiceGenerator::generate()` returns `INV-YYYYMMDD-XXXX` format.
- `StokLog::catat()` is the standard helper for stock logging (in/out).

## Known Issues / Bugs
- `DatabaseSeeder` calls `TransaksiSeeder` **twice** (duplicate call, likely unintended).
- `pelanggans` migration is **missing** from `database/migrations/` but `Pelanggan` model exists.
- `transaksis.kembalian` vs model fillable `kembali` — possible column name mismatch.
- `detail_transaksis.jumlah` vs model fillable `qty` — possible column name mismatch.

## Tests
- Minimal: `tests/Unit/ExampleTest.php` + `tests/Feature/ExampleTest.php` only.
- phpunit.xml uses `testing` DB, `array` cache/session, `sync` queue.
- Run: `sail test` or `php artisan test`

## Frontend Build
- `resources/css/app.css` (Tailwind) + `resources/js/app.js` (entry)
- `sail npm run dev` — Vite dev
- `sail npm run build` — production

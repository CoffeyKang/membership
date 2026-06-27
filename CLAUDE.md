# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Hair salon membership management system. A super-admin (salon owner) creates staff users; those users log in to manage members (balance, transactions, deposits) and staff (payroll, commission, day-offs).

## Commands

```bash
# First-time setup
composer run setup

# Start all dev services (PHP server + queue + log tail + Vite)
composer run dev

# Run all tests
composer run test

# Run a single test file
php artisan test tests/Feature/Auth/AuthenticationTest.php

# Run a single test by name
php artisan test --filter "test_name"

# Lint / format PHP
./vendor/bin/pint

# Build frontend assets
npm run build

# Artisan utilities
php artisan migrate
php artisan migrate:fresh --seed
php artisan tinker
```

Tests use Pest PHP v4 on an in-memory SQLite database (configured in `phpunit.xml`).

## Architecture

### UI Layer: Livewire-first

All interactive UI is built with **Livewire v3** components in `app/Livewire/`. Routes in `routes/web.php` resolve directly to Blade views; those views embed Livewire components. There are no traditional form-submitting controllers — mutations happen inside Livewire component methods. The exception is `DownloadController` (backup download).

**Livewire Volt** (`livewire/volt`) is installed but unused — the codebase uses class-based Livewire components exclusively.

### Core Data Flow

1. **QuickSave** (`app/Livewire/QuickSave.php`) is the primary daily-use screen — staff select a member, enter the service amount, and save. It decrements `member.balance`, creates a `Transaction`, and optionally saves a `MemberSignature` via the `SignaturePad` component.

2. **AddRecords** handles back-dated transaction entry; it manually sets `transaction.created_at`. Service types (haircut variants, coloring, etc.) are hardcoded arrays inside this component — there is no configurable service table.

3. **SpendForm** is an older modal-based variant of the same flow, used from the member detail page.

### Signature Capture Flow

1. `SignaturePad` Livewire component wraps the `smooth-signature` JS library
2. On save, it emits a `saveSignature` event with the canvas base64 data
3. `QuickSave` listens for `saveSignature` and stores it in a public property
4. On form submit, a `MemberSignature` record is created with the base64 data

### Models and Key Relationships

```
Member ──< DepositHistory
Member ──< Transaction ──< MemberSignature
Member ──< MemberSignature
Staff  ──< Transaction
Staff  ──< Dayoff
Staff  ──< PayoutHistory
```

- **Member ID 1** (`散客`) is the walk-in client sentinel. It is hardcoded as the default in `QuickSave`, `AddRecords`, and several queries. Never delete this record — the system depends on its existence.
- **Transaction** uses `SoftDeletes`; deleting cascades to `MemberSignature`.
- **Staff.payout($from, $till)** computes salary, marks transactions `is_paid=true`, archives day-offs, and records a `PayoutHistory`.
- **Staff** day-offs are inferred: any calendar date between the staff's first transaction and today with no transaction is counted as a day off. They are not explicitly entered during the month.

### Global Model Scopes (load-bearing business logic)

| Model | Scope |
|---|---|
| `Transaction` | Orders by `created_at DESC` always |
| `DepositHistory` | Excludes `member_id=1` (walk-in client) always |
| `Dayoff` | Excludes `is_archived=true` always |
| `PayoutHistory` | Orders by `created_at DESC` always |

Be aware of these when writing raw queries or testing edge cases.

### Staff Commission Calculation

`total_salary` = `max(base_salary, commission_amount) + bonus`  
`commission_amount` = `commission_rate × total_sales_in_period`

`Staff::payout()` executes this, creates a `PayoutHistory` record, archives day-offs for the period, and marks all transactions in the period as `is_paid=true`.

### Deposit Types

Stored as integers in `deposit_histories.type`: 0=cash, 1=Alipay, 2=WeChat Pay, 3=open card (initial deposit on member creation). The `DepositHistory` model auto-creates a type=3 record via a `booted()` hook when a new `Member` is created.

### Localization

App locale is `zh_CN` with English fallback. Both `lang/en/messages.php` and `lang/zh_CN/messages.php` are maintained in parallel. Always add keys to both files when adding user-facing strings; never hardcode strings. Use `__('messages.key')`.

### Frontend

- **Tailwind CSS v3** + `@tailwindcss/forms`
- **Vite** with `laravel-vite-plugin`
- **Alpine.js** is included transitively via Livewire v3
- **smooth-signature** npm package powers the `SignaturePad` Livewire component

### Backup

`spatie/laravel-backup` is integrated. `BackupManager` Livewire component (`app/Livewire/BackupManager.php`) exposes backup controls in the UI. Backup files are stored under `storage/app/private/人民发艺/`. `DownloadController` serves backup file downloads using a short-lived token stored in cache.

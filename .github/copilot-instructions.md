<!-- Copilot instructions for AI coding agents working on the pfdb repository -->
# pfdb — Copilot Instructions

Purpose: quick, action-oriented guidance so AI coding agents become productive immediately.

**Quick Environment & Commands**:
- `php` requirement: **PHP 8.4+** (see `composer.json`).
- Install dependencies: `composer install` and `npm install`.
- Project setup (all-in-one): `composer setup` (runs migrations, npm build, etc.).
- Local dev (concurrent services): `composer dev` — runs `php artisan serve`, queue listener, pail, and `npm run dev` via `concurrently`.
- Build assets: `npm run build` or `npm run dev` for vite dev server.
- Run tests: `composer test` (calls `php artisan test`).
- Lint/format: repository includes `laravel/pint` in dev; run `./vendor/bin/pint` or `composer run-script` if added.

**Big-picture architecture**:
- Laravel 12 skeleton with Filament (admin) and Livewire (reactive pages).
- Admin UI: Filament resources live under `app/Filament/Resources/`.
- Frontend pages use Livewire components located in `app/Livewire/` (e.g., `Home`, `CategoryView`) and are directly routed in `routes/web.php` using Livewire classes.
- Data model: EAV-like attributes:
  - `app/Models/Product.php` uses related `ProductAttribute` to store attribute values (see `getEavAttribute` / `setEavAttribute`).
  - Core models: `app/Models/Category.php`, `Product.php`, `Attribute.php`, `ProductAttribute.php`.
- Database: migrations in `database/migrations/` (timestamped), and seeders in `database/seeders/` (e.g., `CategorySeeder`, `ProductSeeder`, `AdminUserSeeder`). Composer scripts create/touch `database/database.sqlite` in provisioning.

**Project-specific patterns & conventions**:
- Models use `$fillable` for mass-assignment (see `Product.php`). Prefer following existing model patterns instead of switching to `$guarded`.
- Attribute storage follows an EAV pattern; prefer using `Product::getEavAttribute($id)` / `setEavAttribute()` when manipulating dynamic attributes.
- Filament admin resources are the authoritative place for CRUD in admin; changing Filament resources typically updates admin behavior.
- Routes map Livewire classes directly: for example, `Route::get('/', Home::class)->name('home');` so changes to Livewire class names or namespaces must be mirrored in `routes/web.php`.

**Build & Dev workflow gotchas**:
- The `composer dev` script runs several processes concurrently (server, queue listener, pail logger, vite). When debugging locally, you can run those pieces separately to isolate failures:
  - `php artisan serve`
  - `php artisan queue:listen --tries=1`
  - `npm run dev` (vite)
- `composer setup` is intended to create `.env`, run migrations and build frontend — use in fresh environments.

**Integration points & external dependencies**:
- Filament (`filament/filament`) for admin UI — check `app/Filament/Resources` for how fields/relations are wired.
- Livewire (`livewire/livewire`) for page components in `app/Livewire`.
- Vite + `laravel-vite-plugin` for asset pipeline; config is `vite.config.js` and front-end entry files in `resources/js`.
- Tailwind is used (see `package.json` devDependencies). Asset behavior is controlled by `resources/css/app.css` and `resources/js/bootstrap.js`.

**Where to look when debugging common tasks**:
- Frontend page behavior: `app/Livewire/*`, Blade views under `resources/views/`.
- Admin behavior: `app/Filament/Resources/*` and related Resource/Pages classes.
- EAV attribute logic: `app/Models/Product.php`, `app/Models/ProductAttribute.php`, `app/Models/Attribute.php`.
- Database schema changes: `database/migrations/*` and seeders in `database/seeders/`.
- CI or setup issues: check `composer.json` `scripts` (notably `setup`, `dev`, `test`).

**Examples** (copy/paste friendly):
- Run the app locally with build/dev services:
  - `composer dev`
- Run tests after updating models/migrations:
  - `composer test`
- Add a dynamic attribute to a product (follow model helper):
  - In code: `$product->setEavAttribute($attributeId, $value);`
  - Read: `$value = $product->getEavAttribute($attributeId);`

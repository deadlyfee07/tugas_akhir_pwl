# Project_Toko_Online

## Stack
- Laravel 12 (PHP ^8.2), Vite 7, Tailwind CSS v4, vanilla JS
- SQLite default (MySQL/MariaDB/PgSQL/SQLServer also configured)
- Auth: Laravel Breeze (API stack) + Sanctum (token-based)
- E-Commerce API: produk, kategori, cart, checkout, payment dummy
- Role: admin (`users.role` column, `Gate::policy` for Category/Product/Order)

## Key commands
| Command | What it does |
|---|---|
| `composer setup` | Full project bootstrap |
| `composer dev` | Runs `artisan serve` + `queue:listen` + `pail` + `npm run dev` concurrently |
| `composer test` | `config:clear` then `php artisan test` |
| `npm run build` | `vite build` |
| `./vendor/bin/pint` | PHP lint (default Laravel rules, no custom config) |
| `php artisan db:seed` | Seed admin (`admin@toko.com`/`password`) + customer + sample products |

## Framework quirks
- Laravel 12 uses the new `bootstrap/app.js` — `Application::configure(...)->withRouting(...)->create()`
- Tailwind v4 uses `@import 'tailwindcss'` in CSS (no `tailwind.config.js`)
- Vite entrypoints: `resources/css/app.css`, `resources/js/app.js`
- Queue/cache/session driver: `database` (SQLite tables)
- Mail driver: `log`
- Middleware aliases registered in `bootstrap/app.php`: `admin`, `verified`

## API structure
- **Public**: `GET /api/categories`, `GET /api/categories/{id}`, `GET /api/products`, `GET /api/products/{id}`
- **Auth** (Sanctum): `/api/cart`, `/api/checkout`, `/api/orders`, `/api/orders/{id}/pay`
- **Admin** (Sanctum + `admin` middleware): `/api/admin/categories/*`, `/api/admin/products/*`, `/api/admin/orders/*`
- Breeze routes: register, login, logout, forgot-password, reset-password, email-verify

## Database
- 10 migrations (users + role, categories, products, carts, cart_items, orders, order_items, payments, cache, jobs)
- Factories: User, Category, Product, Cart, CartItem
- Models with Eloquent relationships: User(1:1 Cart, 1:N Order), Category(1:N Product), Cart(1:N CartItem), Order(1:N OrderItem, 1:1 Payment)

## Testing
- PHPUnit 11 via `php artisan test` (or `composer test`)
- In-memory SQLite in tests (`DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`)
- Suites: `tests/Unit/`, `tests/Feature/`
- 12 tests (2 unit: isAdmin, cart total; 2 feature: products API, cart auth guard; 6 Breeze auth tests)

## Key files
| Path | Purpose |
|---|---|
| `routes/api.php` | All API endpoint definitions |
| `bootstrap/app.php` | Middleware registration, routing config |
| `app/Http/Controllers/Api/*.php` | Public API controllers |
| `app/Http/Controllers/Api/Admin/*.php` | Admin API controllers |
| `app/Http/Middleware/AdminMiddleware.php` | Admin role check |
| `app/Policies/*.php` | Gates for admin-only actions |

## Constraints
- No CI/CD, no pre-commit hooks, no Docker config
- No ESLint/Prettier/PHPStan/Psalm
- Pest plugin allowed in composer but Pest not installed

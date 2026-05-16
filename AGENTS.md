# Project_Toko_Online

## Stack
- Laravel 12 (PHP ^8.2), Blade templates; no frontend JS framework
- Auth: Laravel Breeze (API stack) + Sanctum (token-based)
- SQLite default; also configured for MySQL/MariaDB/PgSQL/SQLServer
- Queue/cache/session: `database` (SQLite tables); Mail: `log`
- Admin role via `users.role` column + `Gate::policy` for Category/Product/Order
- ERD in README.md; 12 migrations; Order statuses: `pending`/`paid`/`processed`/`shipped`/`delivered`/`cancelled`

## Commands
| Command | What it does |
|---|---|
| `composer setup` | `composer install`, create `.env`, `key:generate`, `migrate`, `npm install && npm run build` |
| `composer dev` | Run `artisan serve` + `queue:listen` + `pail` + `npm run dev` concurrently |
| `composer test` | `config:clear` then `php artisan test` |
| `./vendor/bin/pint` | PHP lint (default Laravel rules) |
| `php artisan db:seed` | Seed admin (`admin@toko.com`/`password`) + customer + sample products |

**Note:** Both `composer setup` and `composer dev` require `package.json` (doesn't exist) — will fail.

## Web UI (Blade)
Full Blade web UI at `routes/web.php` alongside the API:
`/products`, `/categories`, `/cart`, `/checkout`, `/orders`, `/admin/*`

## Testing
- PHPUnit 11: `php artisan test` (or `composer test`, which runs `config:clear` first)
- In-memory SQLite (`DB_DATABASE=:memory:`, `QUEUE_CONNECTION=sync`), all tests use `RefreshDatabase`
- 12 tests: 2 Unit (isAdmin, cart total), 2 Feature (products pagination, cart auth guard), 8 Breeze auth
- Factories: User, Category, Product, Cart, CartItem — **no Order/OrderItem/Payment factories**
- `User::factory()->admin()` creates admin role; `->unverified()` for unverified email

## API
- **Public**: `GET /api/categories`, `GET /api/categories/{id}`, `GET /api/products` (filter: `category_id`, `search`, `min_price`, `max_price`, `per_page`), `GET /api/products/{id}`
- **Auth** (Sanctum): `/api/cart`, `/api/checkout`, `/api/orders`, `/api/orders/{id}/pay`
- **Admin** (Sanctum + `admin` middleware): `/api/admin/categories/*`, `/api/admin/products/*`, `/api/admin/orders/*`
- Breeze auth routes: register, login, logout, forgot-password, reset-password, email-verify

## Key files
| Path | Purpose |
|---|---|
| `routes/api.php` | API endpoints |
| `routes/web.php` | Blade web routes |
| `bootstrap/app.php` | Middleware registration, routing config |
| `app/Http/Middleware/AdminMiddleware.php` | Admin role check (`$request->user()->isAdmin()`) |
| `app/Http/Resources/*.php` | API resource transformers |
| `app/Policies/*.php` | Gates for admin-only actions |
| `postman-collection.json` | Interactive API docs |

## Quirks
- No `package.json`, `vite.config.*`, or Tailwind config
- No `config('app.frontend_url')` (normally added by Breeze API); email verification redirects to `/dashboard?verified=1`
- Pest plugin allowed in `composer.json` but Pest not installed

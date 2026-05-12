# Project_Toko_Online

## Stack
- Laravel 12 (PHP ^8.2), vanilla JS; no frontend framework
- Auth: Laravel Breeze (API stack) + Sanctum (token-based)
- SQLite default; also configured for MySQL/MariaDB/PgSQL/SQLServer
- Queue/cache/session: `database` (SQLite tables); Mail: `log`
- Admin role via `users.role` column + `Gate::policy` for Category/Product/Order

## Commands
| Command | What it does |
|---|---|
| `composer setup` | `composer install`, create `.env`, `key:generate`, `migrate`, `npm install && npm run build` |
| `composer dev` | Run `artisan serve` + `queue:listen` + `pail` + `npm run dev` concurrently |
| `composer test` | `config:clear` then `php artisan test` |
| `./vendor/bin/pint` | PHP lint (default Laravel rules) |
| `php artisan db:seed` | Seed admin (`admin@toko.com`/`password`) + customer + sample products |

## Testing
- PHPUnit 11 via `php artisan test` (or `composer test`)
- In-memory SQLite in tests (`phpunit.xml` sets `DB_DATABASE=:memory:`, `QUEUE_CONNECTION=sync`)
- 12 tests: 2 Unit (isAdmin, cart total), 2 Feature (products API pagination, cart auth guard), 8 Breeze auth
- Factories: `User::factory()->admin()` creates admin role; `->unverified()` for unverified email
- All tests use `RefreshDatabase`

## Framework quirks
- Laravel 12: `bootstrap/app.js` uses `Application::configure(...)->withRouting(...)->create()`
- Middleware aliases (`admin`, `verified`) registered in `bootstrap/app.php`
- No `package.json`, `vite.config.*`, or Tailwind config exist — `npm` steps in `composer setup` will fail until frontend assets are added
- `config/app.php` lacks `frontend_url` (normally added by Breeze API stack); email verification redirects to `/dashboard?verified=1`
- `postman-collection.json` at repo root for API testing

## API structure
- **Public**: `GET /api/categories`, `GET /api/categories/{id}`, `GET /api/products` (filter: `category_id`, `search`, `min_price`, `max_price`, `per_page`), `GET /api/products/{id}`
- **Auth** (Sanctum): `/api/cart`, `/api/checkout`, `/api/orders`, `/api/orders/{id}/pay`
- **Admin** (Sanctum + `admin` middleware): `/api/admin/categories/*`, `/api/admin/products/*`, `/api/admin/orders/*`
- Breeze auth routes: register, login, logout, forgot-password, reset-password, email-verify

## Database
- 12 migrations (users + role, cache, jobs, categories, products, carts, cart_items, orders, order_items, payments, personal_access_tokens)
- Factories: User, Category, Product, Cart, CartItem
- Models: User(1:1 Cart, 1:N Order), Category(1:N Product), Cart(1:N CartItem), Order(1:N OrderItem, 1:1 Payment)
- Order statuses: `pending`, `paid`, `processed`, `shipped`, `delivered`, `cancelled`

## Key files
| Path | Purpose |
|---|---|
| `routes/api.php` | All API endpoint definitions |
| `bootstrap/app.php` | Middleware registration, routing config |
| `app/Http/Controllers/Api/*.php` | Public API controllers |
| `app/Http/Controllers/Api/Admin/*.php` | Admin API controllers |
| `app/Http/Middleware/AdminMiddleware.php` | Admin role check (`$request->user()->isAdmin()`) |
| `app/Http/Resources/*.php` | API resource transformers |
| `app/Policies/*.php` | Gates for admin-only actions |
| `postman-collection.json` | Interactive API docs for Postman |

## Constraints
- No CI/CD, no pre-commit hooks, no Docker config
- No ESLint/Prettier/PHPStan/Psalm
- Pest plugin allowed in `composer.json` but Pest not installed

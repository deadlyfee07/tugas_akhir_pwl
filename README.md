# SerbaKlik ID - E-Commerce API

Sistem E-Commerce API-driven sederhana berbasis Laravel 12 dengan fitur manajemen produk, kategori, keranjang belanja, checkout, dan pembayaran multi-metode.

## Tech Stack

- **Backend:** Laravel 12 (PHP ^8.2)
- **Auth:** Laravel Breeze (API stack) + Laravel Sanctum (token-based)
- **Database:** SQLite (default), support MySQL/MariaDB/PostgreSQL/SQLServer
- **Frontend:** Blade templates + Tailwind CSS (CDN), tersedia Web UI dan API

## Fitur

| Fitur | Status | Endpoint |
|---|---|---|
| Autentikasi Register/Login/Logout | ✅ | `/api/register`, `/api/login`, `/api/logout` |
| Manajemen Kategori (Admin) | ✅ | CRUD `/api/admin/categories` |
| Manajemen Produk (Admin) | ✅ | CRUD `/api/admin/products` |
| Lihat Kategori (Publik) | ✅ | `GET /api/categories` |
| Lihat Produk (Publik) | ✅ | `GET /api/products` (filter, search, pagination) |
| Keranjang Belanja | ✅ | `/api/cart` (add, update, remove) |
| Checkout | ✅ | `POST /api/checkout` |
| Riwayat Pesanan | ✅ | `/api/orders` |
| Pembayaran Multi-Metode | ✅ | `POST /api/orders/{id}/pay` (DANA, ShopeePay, GoPay, BRI/BCA/Mandiri VA) |
| Konfirmasi Pembayaran | ✅ | `POST /api/orders/{id}/confirm-payment` |
| Manajemen Pesanan (Admin) | ✅ | `/api/admin/orders` (list, detail, update status) |
| Role & Authorization | ✅ | Admin (gate/policy) + Sanctum middleware |

## Entity Relationship Diagram (ERD)

```
┌──────────────┐       ┌─────────────────┐       ┌──────────────────┐
│    users     │       │   categories    │       │     products     │
├──────────────┤       ├─────────────────┤       ├──────────────────┤
│ id (PK)      │       │ id (PK)         │       │ id (PK)          │
│ name         │       │ name            │──1:N──│ category_id (FK) │
│ email        │       │ slug            │       │ name             │
│ password     │       │ description     │       │ slug             │
│ role         │       │ created_at      │       │ description      │
│ created_at   │       │ updated_at      │       │ price            │
│ updated_at   │       └─────────────────┘       │ stock            │
└──────┬───────┘                                  │ image            │
       │                                          │ created_at       │
       │ 1:1                                      │ updated_at       │
       │                                          └──────────────────┘
       ▼
┌──────────────┐       ┌─────────────────┐
│    carts     │       │   cart_items    │
├──────────────┤       ├─────────────────┤
│ id (PK)      │──1:N──│ id (PK)         │
│ user_id (FK) │       │ cart_id (FK)    │
│ created_at   │       │ product_id (FK) │
│ updated_at   │       │ quantity        │
└──────┬───────┘       │ price           │
       │               │ created_at      │
       │               │ updated_at      │
       ▼ 1:N           └─────────────────┘
┌──────────────┐       ┌─────────────────┐
│    orders    │       │   order_items   │
├──────────────┤       ├─────────────────┤
│ id (PK)      │──1:N──│ id (PK)         │
│ user_id (FK) │       │ order_id (FK)   │
│ order_number │       │ product_id (FK) │
│ status       │       │ quantity        │
│ total_amount │       │ price           │
│ notes        │       │ created_at      │
│ created_at   │       │ updated_at      │
│ updated_at   │       └─────────────────┘
└──────┬───────┘
       │ 1:1
       ▼
┌──────────────┐
│   payments   │
├──────────────┤
│ id (PK)      │
│ order_id (FK)│
│ method       │
│ status       │
│ amount       │
│ transaction  │
│ paid_at      │
│ created_at   │
│ updated_at   │
└──────────────┘
```

### Relasi

- **User → Cart**: One-to-One (setiap user punya 1 keranjang)
- **User → Order**: One-to-Many
- **Cart → CartItem**: One-to-Many
- **Category → Product**: One-to-Many
- **Order → OrderItem**: One-to-Many
- **Order → Payment**: One-to-One

## Alur Sistem (System Flow)

### Alur Belanja (Customer)
```
Register/Login → Lihat Produk → Tambah ke Cart → Checkout → Bayar → Lihat Status Pesanan
```

### Alur Manajemen (Admin)
```
Login Admin → CRUD Kategori & Produk → Lihat Semua Pesanan → Update Status Pesanan
```

### Alur Checkout Detail
```
1. Customer menambahkan produk ke cart
2. Cart menyimpan product_id, quantity, price saat itu
3. Customer POST /api/checkout (atau via Web UI)
4. Sistem: validasi stok → create Order → create OrderItems → kurangi stok → hapus cart
5. Customer pilih metode pembayaran: DANA, ShopeePay, GoPay, BRI VA, BCA VA, Mandiri VA
6. Sistem: generate Virtual Account / kode bayar, simpan payment status "pending"
7. Customer bayar secara eksternal, lalu POST /api/orders/{id}/confirm-payment
8. Sistem: update payment status jadi "success", order status jadi "paid"
```

## Web UI (Blade)

Selain API, tersedia juga antarmuka web berbasis Blade untuk admin dan customer:

| Halaman | URL |
|---------|-----|
| Beranda | `/` |
| Produk | `/products` |
| Detail Produk | `/products/{id}` |
| Kategori | `/categories` |
| Login | `/login` |
| Register | `/register` |
| Keranjang | `/cart` |
| Checkout | `/checkout` |
| Pesanan Saya | `/orders` |
| Detail Pesanan + Bayar | `/orders/{id}` |
| Dashboard Admin | `/admin` |
| Admin - Kelola Produk | `/admin/products` |
| Admin - Kelola Kategori | `/admin/categories` |
| Admin - Kelola Pesanan | `/admin/orders` |

## API Documentation

### Autentikasi (Breeze API)

| Method | Endpoint | Deskripsi | Auth |
|--------|----------|-----------|------|
| POST | `/api/register` | Register user baru | No |
| POST | `/api/login` | Login, return token | No |
| POST | `/api/logout` | Logout, hapus token | Sanctum |
| GET | `/api/user` | Profile user saat ini | Sanctum |

**Register Request:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

**Login Request:**
```json
{
  "email": "john@example.com",
  "password": "password"
}
```

**Login Response:**
```json
{
  "user": { "id": 1, "name": "John Doe", "email": "john@example.com", "role": "customer" },
  "token": "1|abc123..."
}
```

### Public Endpoints

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/categories` | List semua kategori |
| GET | `/api/categories/{id}` | Detail kategori |
| GET | `/api/products` | List produk (dengan filter) |
| GET | `/api/products/{id}` | Detail produk |

**Query Parameters for `/api/products`:**
- `category_id` - Filter by kategori
- `search` - Cari berdasarkan nama
- `min_price` - Harga minimum
- `max_price` - Harga maksimum
- `per_page` - Jumlah per halaman (default: 20)

### Customer Endpoints (Sanctum)

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/cart` | Lihat isi keranjang |
| POST | `/api/cart/add` | Tambah item ke keranjang |
| PUT | `/api/cart/items/{id}` | Update quantity item |
| DELETE | `/api/cart/items/{id}` | Hapus item dari keranjang |
| POST | `/api/checkout` | Proses checkout |
| GET | `/api/orders` | Riwayat pesanan |
| GET | `/api/orders/{id}` | Detail pesanan |
| POST | `/api/orders/{id}/pay` | Buat pembayaran, pilih metode |
| POST | `/api/orders/{id}/confirm-payment` | Konfirmasi pembayaran selesai |

**Add to Cart:**
```json
{
  "product_id": 1,
  "quantity": 2
}
```

**Checkout:**
```json
{
  "notes": "optional notes"
}
```

**Pay Order (pilih metode):**
```json
{
  "payment_method": "dana"
}
```

`payment_method` values: `dana`, `shopeepay`, `gopay`, `bri_va`, `bca_va`, `mandiri_va`

### Admin Endpoints (Sanctum + Admin Middleware)

Use `Authorization: Bearer <token>` header with admin account.

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| POST | `/api/admin/categories` | Tambah kategori |
| PUT | `/api/admin/categories/{id}` | Update kategori |
| DELETE | `/api/admin/categories/{id}` | Hapus kategori |
| POST | `/api/admin/products` | Tambah produk |
| PUT | `/api/admin/products/{id}` | Update produk |
| DELETE | `/api/admin/products/{id}` | Hapus produk |
| GET | `/api/admin/orders` | List semua pesanan |
| GET | `/api/admin/orders/{id}` | Detail pesanan |
| PUT | `/api/admin/orders/{id}/status` | Update status pesanan |

**Create/Update Category:**
```json
{
  "name": "Elektronik",
  "description": "Produk elektronik"
}
```

**Create/Update Product:**
```json
{
  "category_id": 1,
  "name": "Smartphone XYZ",
  "description": "Smartphone terbaru",
  "price": 3500000,
  "stock": 10
}
```

**Update Order Status:**
```json
{
  "status": "processed"
}
```

Status values: `pending`, `paid`, `processed`, `shipped`, `delivered`, `cancelled`

### Standard JSON Response

**Success:**
```json
{
  "data": { ... }
}
```

**Paginated:**
```json
{
  "data": [ ... ],
  "links": { ... },
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 20,
    "total": 100
  }
}
```

**Error:**
```json
{
  "message": "Error description",
  "errors": { "field": ["Validation error"] }
}
```

### Akun Default (Seeder)

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@toko.com | password |
| Customer | customer@toko.com | password |

## Instalasi

```bash
# Clone repository
git clone https://github.com/username/project-toko-online.git
cd project-toko-online

# Install dependencies & setup
composer setup

# Run seeder
php artisan db:seed

# Jalankan development server
composer dev
```

Atau manual:
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
npm install
npm run build
php artisan serve
```

## Testing

```bash
composer test
```

Atau:
```bash
php artisan test
```

## Postman Collection

Import file `postman-collection.json` ke Postman untuk dokumentasi API yang interaktif.

1. Buka Postman → Import → Pilih file
2. Set `base_url` variable ke `http://localhost:8000`
3. Gunakan endpoint Login untuk mendapatkan token
4. Token otomatis tersimpan ke variabel `token`

## Lisensi

Proyek ini dibuat untuk tujuan edukasi sebagai tugas mata kuliah.

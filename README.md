# BKD Provinsi NTB — Panduan Setup

Panduan instalasi database, migration, dan akses halaman admin CMS Berita.

## Persyaratan

- PHP 7.4+ (disarankan 8.x)
- MySQL / MariaDB
- Web server (XAMPP, Laragon, WAMP, atau live server)
- Ekstensi PHP: `mysqli`, `mbstring`, `dom`

---

## 1. Konfigurasi Database

File `application/config/database.php` **tidak di-track git** supaya kredensial live server tidak ke-replace saat deploy.

Salin template dulu:

```cmd
copy application\config\database.php.example application\config\database.php
```

Lalu edit `application/config/database.php`:

```php
'hostname' => 'localhost',
'username' => 'bkdntbprov',
'password' => 'PASSWORD_ANDA',
'database' => 'bkdntbprov_admin',
```

> Database live: **`bkdntbprov_admin`**.  
> CMS berita pakai tabel **`user`** dan **`berita`** sendiri — **tidak menyentuh** tabel `users`, `beritas`, atau tabel lama lainnya.

---

## 2. Setup di Database Live (`bkdntbprov_admin`)

Kalau database sudah di-import dari `bkdntbprov_admin.sql`, jalankan migration untuk **menambah** tabel CMS saja:

```cmd
php scripts\db.php migrate
```

Atau import manual:

```cmd
mysql -u bkdntbprov -p bkdntbprov_admin < database\patches\bkdntbprov_admin_berita_cms.sql
```

Lalu seed berita awal (opsional):

```cmd
php scripts\seed_berita.php
```

**Login admin CMS berita** (tabel `user` terpisah):

| Field | Nilai |
|-------|-------|
| Username | `admin` |
| Password | `admin123` |

---

## 3. Setup & Migration (Database Baru / Lokal)

Semua script DB membaca config dari `application/config/database.php`.

Masuk ke folder project:

```cmd
cd C:\xampp\htdocs\bkd
```

### Lokal (Windows / XAMPP / Laragon)

Buat database + tabel + admin + seed berita:

```cmd
php scripts\db.php migrate --create-db --seed
```

### Live Server (`bkdntbprov_admin` sudah ada)

```cmd
php scripts\db.php migrate
php scripts\seed_berita.php
```

### Database baru (lokal/dev)

```cmd
php scripts\db.php migrate --create-db --seed
```

### Perintah lain

```cmd
php scripts\db.php status
php scripts\db.php migrate
php scripts\db.php migrate --fresh-seed
```

| Perintah | Fungsi |
|----------|--------|
| `migrate` | Jalankan migration baru saja |
| `migrate --create-db` | Buat database dulu (lokal) |
| `migrate --seed` | Migration + seed berita |
| `migrate --fresh-seed` | Migration + hapus & seed ulang berita |
| `status` | Lihat migration yang sudah/belum jalan |
| `install` | Alias `migrate --seed` |

Migration disimpan di `database/migrations/` dan dicatat di tabel `_migrations`.

---

## 3. Setup Manual via SQL (Alternatif)

File SQL: `database/setup.sql`

**XAMPP:**

```cmd
C:\xampp\mysql\bin\mysql.exe -u root -p < database\setup.sql
```

**Laragon:**

```cmd
mysql -u root -p < database\setup.sql
```

Seed berita setelah import SQL:

```cmd
php scripts\seed_berita.php
```

---

## 4. Menjalankan Aplikasi

### XAMPP / WAMP / Laragon

1. Letakkan project di `htdocs` atau `www`
2. Start Apache + MySQL
3. Buka `http://localhost/bkd/`

### Live server

Upload project, arahkan document root ke folder project, lalu jalankan:

```cmd
php scripts/db.php migrate --seed
```

---

## 5. Akses Halaman Admin

| Halaman | URL |
|---------|-----|
| Login admin | `https://domain-anda/admin/login` |
| Daftar berita | `https://domain-anda/admin/berita` |

### Login default

| Field | Nilai |
|-------|-------|
| Username | `admin` |
| Password | `admin123` |

> Ganti password admin setelah deploy production.

---

## 6. Ringkasan Cepat

**Lokal Windows:**

```cmd
cd C:\xampp\htdocs\bkd
php scripts\db.php migrate --create-db --seed
```

**Live server:**

```cmd
cd /path/to/bkd
php scripts/db.php migrate --seed
```

Lalu buka `/admin/login`.

---

## Troubleshooting

**Koneksi database gagal**  
Cek `application/config/database.php` dan pastikan user MySQL punya akses ke database `berita`.

**`php` is not recognized**  
Pakai path penuh PHP, misalnya `C:\xampp\php\php.exe scripts\db.php migrate`.

**Migration sudah jalan tapi tabel kosong**  
Jalankan `php scripts\db.php migrate --seed`.

**Halaman admin 404**  
Pastikan mod_rewrite aktif dan file `.htaccess` ada di root project.

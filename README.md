# BKD Provinsi NTB — Panduan Setup & Deploy

Panduan instalasi database, migration, dan admin CMS Berita.

## Persyaratan

- PHP 7.4+ (disarankan 8.x)
- MySQL / MariaDB
- Web server (Apache/Nginx)
- Ekstensi PHP: `mysqli`, `mbstring`, `dom`
- Git (untuk deploy via pull)

---

## Deploy Setelah Push Kode (Live Server)

Ikuti langkah ini **di server** setelah kode sudah di-push dari lokal dan di-pull di server.

### A. Deploy Pertama Kali

#### Langkah 1 — Masuk ke folder project di server

**Linux / cPanel SSH:**

```bash
cd /path/to/bkd
```

**Windows Server:**

```cmd
cd C:\path\to\bkd
```

#### Langkah 2 — Pull kode terbaru

```bash
git pull origin main
```

> Sesuaikan branch jika bukan `main`.



#### Langkah 3 — Buat file config database (hanya sekali)

File `application/config/database.php` **tidak ikut git** supaya kredensial live tidak ke-replace.

**Linux:**

```bash
cp application/config/database.php.example application/config/database.php
nano application/config/database.php
```

**Windows:**

```cmd
copy application\config\database.php.example application\config\database.php
notepad application\config\database.php
```

Isi kredensial server:

```php
'hostname' => 'localhost',
'username' => 'bkdntbprov',
'password' => 'PASSWORD_SERVER_ANDA',
'database' => 'bkdntbprov_admin',
```

> Pastikan database `bkdntbprov_admin` sudah ada (sudah pernah import `bkdntbprov_admin.sql`).



#### Langkah 4 — Pastikan folder upload bisa ditulis

**Linux:**

```bash
chmod -R 755 assets/images/blog
chmod -R 755 assets/images/blog/content
```

**Windows:** pastikan IIS/Apache user punya hak tulis ke folder `assets\images\blog\`.

#### Langkah 5 — Jalankan migration (tambah tabel CMS)

Hanya menambah tabel `berita` + `user`. **Tidak mengubah** tabel `users`, `beritas`, dll.

```bash
php scripts/db.php migrate
```

Cek status:

```bash
php scripts/db.php status
```

Output yang diharapkan:

```
Sudah dijalankan:
  [x] 001_create_berita_table.sql
  [x] 002_create_cms_user_table.sql
```

**Alternatif manual (Linux — pakai slash** `/`**):**

```bash
mysql -u bkdntbprov -p bkdntbprov_admin < database/patches/bkdntbprov_admin_berita_cms.sql
```

> Jangan pakai backslash `\` di bash/Linux. Itu sintaks Windows.  
> Salah: `database\patches\...` → bash baca jadi `databasepatches...`



#### Langkah 6 — Seed berita awal (opsional, deploy pertama)

```bash
php scripts/db.php migrate
```

> Lewati langkah ini jika berita akan diinput manual lewat admin.



---

## Admin CMS Berita (CodeIgniter)

Halaman admin **CodeIgniter**. Controller di root (bukan subfolder `admin/`) supaya kompatibel nginx/Plesk:

```
application/controllers/Admin_login.php  → /admin/login
application/controllers/Admin_berita.php → /admin/berita
application/views/admin/                 → tampilan admin
```

### URL admin

| Halaman | URL |
|---------|-----|
| Login | `https://domain-anda.com/admin/login` |
| Kelola berita | `https://domain-anda.com/admin/berita` |
| Tambah berita | `https://domain-anda.com/admin/berita/tambah` |

Login: `admin` / `admin123` (tabel `user` di database).

### PENTING — hapus folder Laravel di server

Kalau di **root website** masih ada folder fisik `admin/` (bekas Laravel `admin/public/`), **hapus atau rename**:

```bash
cd /path/to/website-root
mv admin admin_laravel_backup
# atau: rm -rf admin
```

Tanpa ini, Apache bisa mengarahkan `/admin/*` ke folder Laravel, bukan ke CodeIgniter — meskipun `.htaccess` sudah benar.

> Yang dihapus: folder `admin/` di **root server** (Laravel).  
> Bukan `application/controllers/admin/` — itu kode CodeIgniter, jangan dihapus.

### Tes kalau masih error

```text
https://domain-anda.com/index.php/admin/login
```

Kalau URL ini jalan, masalahnya folder `admin/` Laravel atau `.htaccess` lama.

---



### B. Deploy Berikutnya (Update Kode)

Setiap kali ada update kode di-push:

```bash
cd /path/to/bkd
git pull origin main
php scripts/db.php migrate
```

> `application/config/database.php` **tidak akan ke-replace** karena di-ignore git.  
> `php scripts/db.php migrate` aman dijalankan berulang — hanya migration baru yang dijalankan.

Kalau ada migration baru + seed berita:

```bash
php scripts/db.php migrate --seed
```

---



## Ringkasan Command (Copy-Paste)



### Deploy pertama

```bash
cd /path/to/bkd
git pull origin main
cp application/config/database.php.example application/config/database.php
# edit application/config/database.php sesuai kredensial server
php scripts/db.php migrate
php scripts/seed_berita.php
```



### Deploy update biasa

```bash
cd /path/to/bkd
git pull origin main
php scripts/db.php migrate
```



### Windows (Command Prompt)

```cmd
cd C:\path\to\bkd
git pull origin main
copy application\config\database.php.example application\config\database.php
REM edit application\config\database.php
php scripts\db.php migrate
php scripts\seed_berita.php
```

---



## Setup Lokal (Windows / XAMPP)

```cmd
cd C:\xampp\htdocs\bkd
copy application\config\database.php.example application\config\database.php
REM edit database.php — bisa pakai root / password kosong untuk lokal
php scripts\db.php migrate --create-db --seed
```

Buka: `http://localhost/bkd/admin/login`

---



## Struktur Database


| Tabel         | Fungsi                 | Disentuh?          |
| ------------- | ---------------------- | ------------------ |
| `berita`      | Konten berita CMS      | Tabel baru         |
| `user`        | Login admin CMS berita | Tabel baru         |
| `users`       | Sistem lama            | **Tidak disentuh** |
| `beritas`     | Sistem lama            | **Tidak disentuh** |
| `_migrations` | Catatan migration CLI  | Tabel baru         |


---



## Perintah Database CLI


| Perintah                                 | Fungsi                             |
| ---------------------------------------- | ---------------------------------- |
| `php scripts/db.php status`              | Cek migration sudah/belum jalan    |
| `php scripts/db.php migrate`             | Jalankan migration baru            |
| `php scripts/db.php migrate --seed`      | Migration + seed berita            |
| `php scripts/db.php migrate --create-db` | Buat database dulu (lokal)         |
| `php scripts/db.php install`             | Alias `migrate --seed`             |
| `php scripts/seed_berita.php`            | Seed berita saja                   |
| `php scripts/seed_berita.php --fresh`    | Hapus semua berita lalu seed ulang |


Config dibaca dari `application/config/database.php`.

---



## Troubleshooting

### Error 500 Internal Server Error

Pastikan `.htaccess` pakai format ini (bukan `index.php?/...`):

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
```

> Server kamu sebelumnya pakai `index.php/$1` (tanpa `?`). Format `index.php?/$1` bisa bikin **404 Not Found**.

Tes langsung tanpa rewrite:
```
https://domain-anda.com/index.php/admin/login
```

Jalankan diagnosa:

```bash
php scripts/check_env.php
```

**Penyebab lain:**

1. **`database.php` belum dibuat** (file ini tidak ikut git)
   ```bash
   cp application/config/database.php.example application/config/database.php
   nano application/config/database.php
   ```

2. **`.htaccess` / mod_rewrite** — sudah dipakai format `index.php?/$1` yang lebih kompatibel. Pastikan `AllowOverride All` aktif di Apache.

3. **Folder tidak writable**
   ```bash
   chmod -R 755 application/cache application/logs assets/images/blog
   ```

4. **Cek error log Apache**
   ```bash
   tail -50 /var/log/httpd/error_log
   ```
   atau cPanel → Errors / Error Log

5. **Tes PHP tanpa rewrite** — buka langsung:
   ```
   https://domain-anda.com/index.php/admin/login
   ```
   Kalau ini jalan tapi `/admin/login` tidak, masalahnya di `.htaccess`/mod_rewrite.

**Koneksi database gagal**  
Cek `application/config/database.php` — hostname, username, password, dan nama database harus sesuai server.

`php` **is not recognized (Windows)**  

```cmd
C:\xampp\php\php.exe scripts\db.php migrate
```

**Migration sudah jalan tapi berita kosong**  

```bash
php scripts/seed_berita.php
```

**Halaman admin 404**  
Pastikan mod_rewrite Apache aktif dan file `.htaccess` ada di root project.

**Upload gambar gagal**  
Pastikan folder `assets/images/blog/` dan `assets/images/blog/content/` writable.

**Login gagal padahal migration sudah jalan**  
Pastikan login pakai akun tabel `user` (bukan `users`). Default: `admin` / `admin123`.
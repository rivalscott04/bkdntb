# Cara ubah CSS (supaya tidak berantakan)

Website memakai **`bundle.css`** di header (bukan `style.css` langsung).
Ini supaya request CSS tidak meledak di shared hosting.

## Aturan utama

1. **Jangan edit** `assets/css/bundle.css` manual.
2. Edit file **sumber**, lalu **rebuild** bundle.
3. Setelah rebuild, commit `bundle.css` ikut, lalu deploy (`git pull` di server).
4. Hard refresh browser (`Cmd+Shift+R` / `Ctrl+Shift+R`).

## File mana yang diedit

| Mau ubah | Edit file ini | Catatan |
|----------|---------------|---------|
| Tampilan tema utama (warna, layout, komponen) | `assets/css/style.css` | File master tema |
| Tampilan mobile / breakpoint | `assets/css/responsive.css` | Dipakai terpisah di header |
| Panel admin | `assets/css/admin.css` | Hanya admin |
| Bootstrap / plugin (jarang) | file di `assets/css/` atau path `@import` di `style.css` | Setelah ubah, wajib rebuild |

Header memuat:

- `assets/css/bundle.css` (hasil gabungan `style.css` + `@import`)
- `assets/css/responsive.css`
- Admin menambah `assets/css/admin.css`

## Langkah ubah CSS (aman)

### 1) Edit sumber

Contoh: ubah warna tombol di `style.css`, atau layout mobile di `responsive.css`.

### 2) Rebuild bundle

Dari root project:

```bash
python3 scripts/rebuild-css-bundle.py
```

Skrip ini menulis ulang `assets/css/bundle.css` dari `style.css` dan semua file yang di-`@import`.

### 3) Cek lokal

Buka halaman terkait, hard refresh, pastikan gaya berubah.

### 4) Commit dan deploy

```bash
git add assets/css/style.css assets/css/responsive.css assets/css/admin.css assets/css/bundle.css
git commit -m "Update CSS theme"
git push origin main
```

Di server:

```bash
git pull origin main
```

## Yang sering bikin berantakan (hindari)

- Edit `bundle.css` langsung, lalu lain waktu rebuild menimpa perubahanmu
- Ubah hanya `style.css` tanpa rebuild (live tetap pakai bundle lama)
- Menambah `@import` baru di `style.css` tanpa rebuild
- Menyimpan CSS custom di banyak file acak tanpa dokumentasi
- Menghapus `@import` di `style.css` tanpa paham dampak ke bundle

## Custom CSS kecil (opsional, lebih rapi)

Kalau perubahan kecil dan sering (warna brand, spacing admin, dsb.), lebih aman buat file sendiri:

1. Buat `assets/css/custom.css`
2. Tambahkan di `application/views/header.php` (dan admin `shell_head.php` bila perlu) **setelah** bundle/responsive:

```php
<link rel="stylesheet" href="<?php echo base_url().'assets/'?>css/custom.css">
```

3. Isi override di `custom.css`
4. File ini **tidak** perlu masuk bundle, jadi tidak tertimpa rebuild

Pakai pola ini untuk tweak jangka panjang. Pakai edit `style.css` + rebuild untuk perubahan tema besar.

## Catatan soal `/assets` vs `/media`

Di production, URL HTML yang berisi `/assets/...` di-rewrite otomatis ke `/media/...`
(lewat hook `Asset_url_rewrite` + controller `Media`) supaya file static tidak kena
`ERR_CONNECTION_RESET` dari nginx shared hosting.

Di view PHP, tetap tulis path seperti biasa:

```php
<?php echo base_url().'assets/'?>css/custom.css
```

Tidak perlu ganti ke `/media` manual.

## Checklist cepat sebelum push

- [ ] Sumber yang diedit sudah benar (`style.css` / `responsive.css` / `admin.css` / `custom.css`)
- [ ] Jika sentuh `style.css` atau file `@import`: sudah jalankan `python3 scripts/rebuild-css-bundle.py`
- [ ] `bundle.css` ikut ter-commit (kecuali hanya ubah `responsive.css`, `admin.css`, atau `custom.css`)
- [ ] Sudah hard refresh setelah deploy

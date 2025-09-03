# Panduan Deployment - Sistem Manajemen Kantor Camat

## Masalah Gambar Tidak Terbaca Saat Online

Jika gambar tidak terbaca saat aplikasi di-deploy ke server online, ikuti langkah-langkah berikut:

### 1. Konfigurasi APP_URL

Pastikan `APP_URL` di file `.env` sesuai dengan domain website Anda:

```env
# Untuk development lokal
APP_URL=http://localhost

# Untuk production - ganti dengan domain Anda
APP_URL=https://yourdomain.com
```

### 2. Membuat Symbolic Link Storage

Jalankan command berikut di server production:

```bash
php artisan storage:link
```

Command ini akan membuat symbolic link dari `storage/app/public` ke `public/storage`.

### 3. Verifikasi Struktur Folder

Pastikan struktur folder berikut ada di server:

```
storage/
└── app/
    └── public/
        ├── gallery/
        └── news/

public/
└── storage/ (symbolic link ke storage/app/public)
```

### 4. Permissions (Linux/Unix Server)

Jika menggunakan server Linux/Unix, pastikan permissions yang benar:

```bash
# Set permissions untuk storage
chmod -R 755 storage/
chmod -R 755 public/storage/

# Set ownership (ganti 'www-data' dengan user web server Anda)
chown -R www-data:www-data storage/
chown -R www-data:www-data public/storage/
```

### 5. Konfigurasi Web Server

#### Apache (.htaccess)
File `.htaccess` sudah dikonfigurasi dengan benar. Pastikan mod_rewrite aktif.

#### Nginx
Tambahkan konfigurasi berikut untuk melayani file static:

```nginx
location ~* \.(jpg|jpeg|png|gif|ico|css|js)$ {
    expires 1y;
    add_header Cache-Control "public, immutable";
    try_files $uri $uri/ =404;
}
```

### 6. Troubleshooting

#### Cek Symbolic Link
```bash
# Linux/Unix
ls -la public/storage

# Windows
dir public\storage
```

#### Cek File Gambar
```bash
# Pastikan file gambar ada
ls -la storage/app/public/gallery/
ls -la storage/app/public/news/
```

#### Test URL Gambar
Buka URL berikut di browser untuk test:
```
https://yourdomain.com/storage/gallery/nama_file_gambar.jpg
```

### 7. Solusi Alternatif

Jika symbolic link tidak berfungsi, Anda bisa menggunakan helper `Storage::url()` sebagai gantinya:

```php
<!-- Ganti dari -->
<img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}">

<!-- Menjadi -->
<img src="{{ Storage::url($gallery->image) }}" alt="{{ $gallery->title }}">
```

Jangan lupa tambahkan `use Illuminate\Support\Facades\Storage;` di bagian atas file controller atau view.

### 8. Konfigurasi Tambahan untuk Production

#### Cache Configuration
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### Optimize Autoloader
```bash
composer install --optimize-autoloader --no-dev
```

### 9. Checklist Deployment

- [ ] Update `APP_URL` di file `.env`
- [ ] Jalankan `php artisan storage:link`
- [ ] Set permissions yang benar (Linux/Unix)
- [ ] Test upload gambar baru
- [ ] Test tampilan gambar yang sudah ada
- [ ] Verifikasi symbolic link berfungsi
- [ ] Cache configuration untuk production

---

**Catatan:** Pastikan untuk backup database dan file sebelum melakukan deployment ke production.
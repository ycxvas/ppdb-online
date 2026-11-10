# PPDB Online

Aplikasi penerimaan peserta didik baru (PPDB) berbasis **Laravel 11**.

## Fitur

- Formulir pendaftaran publik dengan unggah dokumen (PDF/JPG/PNG, maks 2 MB)
- Nomor pendaftaran otomatis, contoh `PPDB-2026-0001`
- Kuota per jurusan, dengan sisa kuota ditampilkan di formulir
- Cek status pendaftaran memakai **nomor pendaftaran + NISN** (tanpa login)
- Panel admin: cari, filter, verifikasi (menunggu / diterima / cadangan / ditolak), catatan, unduh dokumen
- Dokumen disimpan di storage privat, hanya admin yang bisa mengunduh
- Pembatasan percobaan (throttle) di form, cek status, dan login
- Penerimaan pendaftar dikunci per jurusan, sehingga kuota tidak bisa terlewati saat ada beberapa admin

## Persyaratan

- PHP 8.2+ dan Composer
- Database yang didukung Laravel (SQLite, MySQL, dsb.)

## Cara pasang

Repo ini berisi file khusus aplikasi. Kerangka Laravel-nya dibuat dari composer.

```bash
composer create-project laravel/laravel ppdb-online
git clone https://github.com/ycxvas/ppdb-online repo-ppdb

# salin file aplikasi ke atas proyek Laravel baru (timpa file yang sama)
cp -r repo-ppdb/app repo-ppdb/database repo-ppdb/resources repo-ppdb/routes ppdb-online/

cd ppdb-online
```

Lalu tambahkan pengaturan dari `.env.example` di repo ini ke file `.env` proyekmu. Isinya bahasa Indonesia, zona waktu, dan akun admin:

```
APP_LOCALE=id
APP_FALLBACK_LOCALE=id
APP_TIMEZONE=Asia/Jakarta

ADMIN_NAMA="Admin PPDB"
ADMIN_EMAIL=admin@contoh.sch.id
ADMIN_PASSWORD=ganti-dengan-sandi-kuat
```

Jika `ADMIN_PASSWORD` dikosongkan, seeder membuat sandi acak dan menampilkannya di terminal.

Lalu jalankan:

```bash
php artisan migrate --seed
php artisan serve
```

- Formulir pendaftaran: `http://localhost:8000/`
- Cek status: `http://localhost:8000/cek-status`
- Panel admin: `http://localhost:8000/admin`

## Struktur utama

- `app/Http/Controllers/PendaftaranController.php`: pendaftaran dan cek status
- `app/Http/Controllers/Admin/`: login dan verifikasi pendaftar
- `app/Models/`: `Jurusan`, `Pendaftar`
- `database/migrations/`, `database/seeders/DatabaseSeeder.php`
- `resources/views/`: tampilan Blade (Tailwind via CDN)
- `routes/web.php`

## Catatan produksi

- Set `APP_ENV=production` dan `APP_DEBUG=false`.
- Ganti jurusan dan kuota contoh di `DatabaseSeeder.php` sesuai sekolahmu.
- Gunakan HTTPS, karena aplikasi memproses data pribadi siswa.
- Tampilan memakai Tailwind lewat CDN agar mudah dicoba. Untuk produksi, sebaiknya build Tailwind lewat Vite.
- Jangan pernah meng-commit file `.env` atau isi folder `storage/app` (dokumen pendaftar). `.gitignore` di repo ini sudah mengecualikannya.

## Kontribusi

Issue dan pull request dipersilakan.

## Lisensi

Dirilis di bawah [lisensi MIT](LICENSE).

# Mini Payment App

Sistem pembayaran sederhana antar pengguna berbasis Laravel dengan fitur transfer saldo, mutasi wallet, logging transaksi polymorphic, dan dashboard rekap transaksi.

## Requirement

- PHP 8.3+
- MySQL
- Composer
- Laragon / Laravel Herd / MAMP (disarankan)
- Hindari XAMPP

## Instalasi

1. Clone repository lalu masuk folder project:
   git clone <repo-url>
   cd mini-payment-app

2. Install dependency:
   composer install

3. Copy file environment:
   cp .env.example .env

4. Setup database di .env:
   DB_DATABASE=payment
   DB_USERNAME=root
   DB_PASSWORD=

5. Jalankan installer aplikasi (auto migrate + auto generate key + auto seeder):
   php artisan payment:install

Command ini otomatis menjalankan migration dan seeder, jadi tidak perlu php artisan migrate, generate:key, dan db:seed.

## Default Login

Ambil user dari tabel users.
Password default semua user: password

## Cara Penggunaan

### Halaman Utama

Setelah login, user akan diarahkan ke halaman home berisi panduan penggunaan aplikasi.

### Transfer Antar Pengguna

- Pilih user penerima
- Masukkan nominal minimal 10.000
- Jika saldo tidak cukup, transaksi ditolak
- Catatan bersifat opsional
- Hasil transaksi akan muncul di log aktivitas

### Mutasi / Balance

- Top up saldo
- Withdraw / pengurangan saldo
- Jika saldo tidak cukup wajib top up terlebih dahulu

### Dashboard Admin

- Rekap transaksi user
- Filter berdasarkan tanggal
- Riwayat transfer dan mutasi saldo

## Penjelasan Teknis

### Teknologi

Backend:

- Laravel + MySQL.

Frontend JS:

- VueJS

Frontend CSS dan Template:

- Bootstrap 5
- Skote Template

## Modular Architecture

Menggunakan laravel modules, bukan dari laravel fresh bawaaan, jadi proyek dibuat di dalam modules

Modules/

- Account
  Berisi data untuk manajemen user.

- Portal
  Dashboard admin pada aplikasi, berisi rekap mutasi dan transfer antar nasabah, bisa menggunakan filter tanggal untuk pencarian datanya.

- Web
  Bagian Front/depan untuk menjalankan transaksi atau mutasi.

Setiap modul berisi Controller, Model, Service, Migration.

Keuntungan:

- Scalable
- Clean architecture
- Cocok untuk ERP
- Minim konflik development

### Polymorphic Logging Transaction System

modelable_type
modelable_id

Jenis:

- PayTransaction → Transfer
- UserBalance → Mutasi

Keuntungan:

- Satu tabel semua transaksi
- Struktur database lebih bersih
- Mudah dikembangkan

## Arsitektur Sistem

Dirancang untuk sistem keuangan untuk nantinya jika mengarah ke skala besar.

Fitur:

- Transfer antar user
- Top up saldo
- Withdraw saldo
- History transaksi lengkap
- API mutasi & transfer

## Asumsi & Pertimbangan Pengembangan

### Struktur Aplikasi

Dalam pengembangan sistem ini, saya berasumsi bahwa aplikasi keuangan ini berpotensi berkembang menjadi sistem yang lebih besar, di masa mendatang.

Oleh karena itu, struktur project tidak menggunakan pola default Laravel sepenuhnya, melainkan menggunakan pendekatan modular berbasis Laravel Modules.

Dengan pendekatan ini, setiap fitur dipisahkan ke dalam modul tersendiri (Controller, Model, Service, hingga Migration), sehingga:

- Setiap modul bersifat independen
- Mengurangi konflik antar developer
- Memudahkan pengembangan fitur baru
- Lebih mudah dalam maintenance sistem jangka panjang

---

### Fitur Transfer & Pengelolaan Saldo

Saya juga berasumsi bahwa sistem pembayaran tidak hanya sebatas transfer antar pengguna, tetapi juga harus mendukung pengelolaan saldo secara fleksibel.

Sehingga sistem dirancang untuk mendukung:

- Transfer antar pengguna (debit & credit)
- Penambahan saldo (top up)
- Pengurangan saldo (withdrawal)

Hal ini membuat sistem lebih realistis seperti sistem keuangan pada umumnya.

---

### Struktur Tabel Transfer (pay_transactions)

Tabel ini digunakan untuk mencatat transaksi transfer antar pengguna.

Struktur utama:

- `transaction_code` → kode unik transaksi
- `sender_id` → user pengirim (relasi ke users)
- `receiver_id` → user penerima (relasi ke users)
- `amount` → nominal transfer
- `status` → status transaksi (success/pending/failed)
- `description` → catatan tambahan (opsional)

Tabel ini juga dilengkapi index pada:

- `transaction_code`
- `created_at`

untuk meningkatkan performa pencarian dan filter data transaksi.

---

### Struktur Saldo & Mutasi (user_balances & user_log_balances)

Sistem saldo dibagi menjadi dua bagian:

#### 1. user_balances

Tabel ini menyimpan total saldo user saat ini.

Struktur:

- `user_balance_id` → relasi ke tabel users
- `amount` → jumlah saldo pengguna

Tabel ini berfungsi sebagai sumber utama saldo aktual setiap user.

---

#### 2. user_log_balances

Tabel ini digunakan untuk mencatat seluruh aktivitas perubahan saldo (audit log).

Struktur:

- `adjustment_status` → jenis perubahan saldo (top up / withdraw)
- `modelable_type` → sumber transaksi (PayTransaction / UserBalance)
- `modelable_id` → ID referensi transaksi
- `log_user` → informasi user atau deskripsi log

Tabel ini menjadi pusat histori seluruh aktivitas saldo user, baik dari transfer maupun mutasi manual.

---

### API & Endpoint Sistem

Untuk mengakses API ini, disarankan untuk menyesuaikan `base_url` sesuai dengan environment yang digunakan.
Pada project ini, karena menggunakan Laravel Herd, maka `base_url` yang digunakan adalah `payment.test`.
Silakan sesuaikan `base_url` tersebut dengan konfigurasi domain atau environment lokal masing-masing.

### 📮 Postman Documentation

Dokumentasi lengkap API beserta collection Postman dapat diakses melalui link berikut:
https://documenter.getpostman.com/view/10472510/2sBXwpQCgG

#### Login

Sebelum mengakses fitur Balance dan Transfer, pengguna wajib melakukan autentikasi melalui endpoint login.

Setelah login berhasil, sistem akan mengembalikan `x-api-token` yang digunakan sebagai API authentication token.

Token ini harus disertakan pada setiap request di Postman melalui header:

x-api-token: {token_value}

#### Balance (Saldo)

Pada bagian balance, tersedia endpoint yang memungkinkan:

- Pengguna melakukan penambahan saldo melalui perangkat mobile tanpa harus mengakses website
- Melihat rincian saldo secara lengkap (total masuk dan keluar)
- Melihat seluruh riwayat mutasi saldo pengguna

Fitur ini dibuat agar pengguna dapat memantau kondisi keuangan mereka secara real-time dan fleksibel.

---

#### Transfer

Modul transfer digunakan untuk proses perpindahan saldo antar pengguna.

Fitur yang tersedia:

- Melakukan transaksi antar pengguna (pengirim dan penerima)
- Menyediakan daftar user sebagai pilihan penerima
- Mendukung kebutuhan form selection pada frontend
- Menyimpan riwayat transaksi untuk keperluan rekap berdasarkan tanggal

Dengan desain ini, sistem dapat digunakan baik untuk kebutuhan aplikasi web maupun API-based integration di masa depan.

## Kesimpulan

Mini Payment App adalah sistem wallet berbasis Laravel dengan arsitektur modular dan polymorphic design yang siap dikembangkan menjadi lebih kompleks.

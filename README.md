# SQS - Smart Quiz System

SQS adalah platform manajemen kuis berbasis web yang dibangun menggunakan framework **Laravel**. Aplikasi ini dirancang untuk memungkinkan pengguna membuat, membagikan, dan mengerjakan kuis dengan fitur-fitur canggih seperti bantuan AI, sistem pembayaran, dan verifikasi akademik.

## 🚀 Fitur Utama

* **Manajemen Kuis**: Membuat, mengedit, dan menghapus kuis dengan berbagai opsi pertanyaan.
* **Integrasi AI (Google Gemini)**: Menggunakan `GeminiService` untuk pembuatan soal otomatis atau analisis jawaban/hasil kuis.
* **Sistem Membership & Premium**: Batasan penggunaan AI dan fitur premium untuk pengguna berbayar.
* **Gateway Pembayaran**: Integrasi dengan **Midtrans** untuk memproses transaksi berlangganan.
* **Verifikasi Akademik**: Sistem verifikasi status pelajar/mahasiswa (`AcademicVerificationController`).
* **Leaderboard**: Papan peringkat untuk melihat skor tertinggi pengguna lain.
* **Role Management**: Panel khusus untuk Admin dan User biasa.
* **Autentikasi Sosial**: Mendukung login/register menggunakan akun sosial (Google).

## 🛠️ Teknologi yang Digunakan

* **Backend**: Laravel 11 (PHP)
* **Frontend**: Blade Templates, Tailwind CSS, Alpine.js (via Laravel Breeze/Standard stack)
* **Database**: MySQL
* **AI**: Google Gemini API
* **Payment**: Midtrans Payment Gateway
* **Build Tool**: Vite

## 📋 Prasyarat

Sebelum memulai, pastikan Anda telah menginstal:

* PHP >= 8.2
* Composer
* Node.js & NPM
* MySQL

## ⚙️ Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal Anda:

1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/username/sqs1.git](https://github.com/username/sqs1.git)
    cd sqs1
    ```

2.  **Install Dependensi PHP**
    ```bash
    composer install
    ```

3.  **Install Dependensi Frontend**
    ```bash
    npm install
    ```

4.  **Konfigurasi Environment**
    Salin file contoh `.env` dan buat konfigurasi baru:
    ```bash
    cp .env.example .env
    ```

5.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

6.  **Konfigurasi Database & API**
    Buka file `.env` dan sesuaikan pengaturan berikut:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=root
    DB_PASSWORD=

    # Konfigurasi Midtrans (Pembayaran)
    MIDTRANS_MERCHANT_ID=your_merchant_id
    MIDTRANS_CLIENT_KEY=your_client_key
    MIDTRANS_SERVER_KEY=your_server_key
    MIDTRANS_IS_PRODUCTION=false

    # Konfigurasi Google Gemini AI
    GEMINI_API_KEY=your_gemini_api_key

    # Konfigurasi Google OAuth (Opsional)
    GOOGLE_CLIENT_ID=your_google_client_id
    GOOGLE_CLIENT_SECRET=your_google_client_secret
    GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
    ```

7.  **Migrasi Database**
    Jalankan migrasi untuk membuat tabel yang diperlukan (termasuk tabel quizzes, questions, transactions, dll):
    ```bash
    php artisan migrate
    # Sertakan juga data dummy nya
    php artisan migrate --seed
    ```

8.  **Build Assets**
    ```bash
    npm run build
    ```

## ▶️ Menjalankan Aplikasi

Jalankan server lokal Laravel:

```bash
php artisan serve

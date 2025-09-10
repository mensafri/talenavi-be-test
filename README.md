## Technical Test Backend - Talenavi (Todo List API)

Ini adalah repositori untuk proyek technical test Backend Developer di Talenavi. Proyek ini merupakan sebuah REST API sederhana untuk aplikasi To-do List yang dibangun menggunakan Laravel 11.

## Fitur Utama

✅ Create Todo: Menambahkan data to-do baru ke dalam sistem.

✅ Excel Report: Menghasilkan laporan dalam format .xlsx yang berisi semua data to-do.

✅ Filtering Lanjutan: Laporan Excel mendukung filter berdasarkan judul, penerima tugas, status, dan prioritas.

✅ Ringkasan Otomatis: Laporan Excel menyertakan baris ringkasan (summary row) untuk total tugas dan total waktu yang terlacak.

✅ Chart API: Menyediakan endpoint untuk agregasi data yang siap digunakan untuk membuat chart di frontend, dengan ringkasan berdasarkan:

Status

Prioritas

Penerima Tugas (Assignee)

## Teknologi yang Digunakan

Framework: Laravel 11

Bahasa: PHP 8.2

Database: SQLite (untuk kemudahan instalasi)

Paket Tambahan: Maatwebsite/Excel untuk fungsionalitas ekspor ke Excel.

## Panduan Instalasi & Konfigurasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda.

1. Clone Repositori
   Pertama, clone repositori ini ke mesin lokal Anda menggunakan Git.

Bash

`git clone https://github.com/mensafri/talenavi-be-test.git`

`cd nama-repo-anda`

2. Instal Dependensi
   Instal semua dependensi PHP yang diperlukan menggunakan Composer.

Bash

`composer install`

3. Konfigurasi Environment
   Salin file .env.example menjadi .env. File ini akan berisi semua konfigurasi lingkungan untuk aplikasi Anda.

Bash

`cp .env.example .env`
Setelah itu, buat application key baru untuk aplikasi Laravel Anda.

Bash

`php artisan key:generate`

5. Jalankan Migrasi Database
   Jalankan migrasi untuk membuat tabel todos di dalam database SQLite Anda.

Bash

`php artisan migrate`

## Menjalankan Aplikasi

Setelah semua langkah instalasi selesai, jalankan server pengembangan lokal Laravel.

Bash

`php artisan serve`

Aplikasi Anda sekarang akan berjalan dan dapat diakses di http://127.0.0.1:8000.

## Daftar API Endpoint

Berikut adalah daftar endpoint API yang tersedia untuk diuji.

1. Create Todo
   Method: POST

Endpoint: `/api/todos`

Body (raw/json):

JSON
`{
"title": "Selesaikan Laporan Bulanan",
"assignee": "John Doe",
"due_date": "2025-12-20",
"priority": "high",
"status": "in_progress",
"time_tracked": 120
}`

2. Generate Excel Report
   Method: GET

Endpoint: `/api/todos/report`

Query Parameters (Opsional):

title: string (pencarian parsial)

assignee: string (pencarian parsial)

status: pending | open | in_progress | completed

priority: low | medium | high

Contoh Penggunaan:

`/api/todos/report` (tanpa filter)

`/api/todos/report?status=completed&priority=high` (dengan filter)

3. Get Chart Summary
   Method: GET

Endpoint: `/api/chart`

Query Parameters (Wajib):

type: status | priority | assignee

Contoh Penggunaan:

`/api/chart?type=status`

`/api/chart?type=priority`

`/api/chart?type=assignee`

## Koleksi Postman

https://universal-spaceship-688419.postman.co/workspace/My-Workspace~afd869a3-79f4-48b5-8f8a-fa7427e22fe5/collection/26699112-a5d0ee25-9881-45ea-9abe-bfe805ac3c2f?action=share&creator=26699112

# Software Requirement Specification (SRS)

## 1. Project Overview

Nama Project:
CampusFreelance / MahasiswaHub / SkillMarket

Deskripsi:

Platform marketplace internal kampus yang menghubungkan mahasiswa penyedia jasa dengan pengguna yang membutuhkan jasa.

Tujuan:

- Menjadi marketplace jasa internal kampus
- Menyediakan sistem transaksi layanan terstruktur
- Membangun reputasi pengguna melalui rating dan review
- Menjadi simulasi dunia freelance profesional

---

## 2. User Roles

### Mahasiswa/User

Hak akses:

- Register/Login
- Mengelola profil
- Membuat jasa
- Memesan jasa
- Chat
- Memberikan review

### Admin

Hak akses:

- Mengelola user
- Moderasi jasa
- Monitoring transaksi

---

## 3. Functional Requirements

### Authentication

- Register
- Login
- Logout
- Middleware auth
- Role based access

### Profile

- Upload foto
- Isi bio
- Skill multi-tag
- Portfolio upload
- Rating rata-rata

### Service

- Create service
- Update service
- Delete service
- Kategori
- Harga
- Status aktif/nonaktif

### Marketplace

- List jasa
- Search
- Filter kategori
- Sorting

### Order

- Buat order
- Input kebutuhan
- Status order

Status:

- pending
- diproses
- selesai
- dibatalkan

### Payment

- Simulasi pembayaran
- Upload bukti
- Status pembayaran

### Chat

- Kirim pesan
- Read/unread
- Polling sederhana

### Review

- Rating 1-5
- Komentar
- Validasi selesai order

---

## 4. Non Functional Requirements

Performance:

- Response API < 2 detik

Security:

- Authentication required
- Authorization policy
- Password hashing
- CSRF protection

Scalability:

- Modular architecture
- REST API support

Availability:

- Target uptime 99%
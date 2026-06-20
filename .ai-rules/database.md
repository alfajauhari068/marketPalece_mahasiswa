# database.md

Purpose
-------
Aturan sentral untuk desain dan evolusi database proyek.

Rules
-----
- Gunakan unsigned big integer `id` sebagai PK.
- Gunakan migrations untuk perubahan schema; hindari perubahan manual di produksi.
- FK harus didefinisikan dengan `ON DELETE` policy yang eksplisit.
- Tambahkan index pada kolom yang sering di-query, dan gunakan `docs/DATABASE-SPEC.md` sebagai sumber kebenaran untuk tabel/kolom.
- Jangan buat tabel atau kolom baru tanpa memperbarui `docs/DATABASE-SPEC.md` dan mendapatkan persetujuan proyek.
- Soft delete hanya untuk data yang aman dihapus; `orders` harus tetap immutable, gunakan `status` untuk pembatalan.
- Validasi setiap perubahan skema terhadap data model dan flow bisnis yang tercatat di `docs/`.

Schema Restriction
------------------
AI DILARANG:
- membuat tabel baru
- mengubah relasi utama
- menambah kolom inti
- membuat audit table

Kecuali:
1. disebut di docs/
2. diminta eksplisit user
3. perubahan telah disetujui

Performance
-----------
- Pertimbangkan denormalisasi untuk `rating_avg` dan cached counters.
- Gunakan audit trail atau tabel logging untuk perubahan status penting tanpa merusak integritas transaksi.

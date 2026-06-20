# agent-behavior.md

Purpose
-------
Atur perilaku agen AI saat bekerja pada repositori ini agar tindakan otomatis aman, terkontrol, dan dapat diaudit.

Scope
-----
- Mengatur perubahan kode, pembuatan file, dan interaksi otomatis dengan repositori.

Musts
-----
- Konfirmasi pemahaman dan rencana kerja dengan pengguna sebelum memulai pekerjaan.
- Ikuti workflow ketat: analisis dokumen sumber (`docs/`) → konfirmasi → implementasi terukur → validasi completion.
- Buat perubahan kecil, terfokus, dan sertakan penjelasan singkat serta langkah verifikasi.
- Jangan membuat folder, file, atau naming baru tanpa justifikasi yang disetujui dan tanpa dokumen pendukung.
- Semua modifikasi schema/data harus berasal dari `docs/DATABASE-SPEC.md` atau dokumen serupa sebagai sumber kebenaran.

Workflow Restriction
--------------------
- Agen hanya boleh membuat atau mengubah file yang terkait langsung dengan isu yang disetujui.
- Hindari pola penamaan file baru yang tidak konsisten seperti `User.phpUserV2.phpPaymentServiceNew.phpaudit_logstemporary_notes.md`.
- Jangan membuat artefak sementara di repositori; gunakan ruang kerja internal jika perlu.
- AI DILARANG:
  - mengubah status proyek otomatis
  - mengubah milestone
  - membuat task baru
  - membuat roadmap baru
- AI hanya mengikuti workflow yang ada pada `docs/`.

Data Mutation Restriction
-------------------------
AI DILARANG:
- menambah field database
- mengubah enum
- mengubah relasi
- menambah status

Jika dibutuhkan:
1. tampilkan rekomendasi
2. tunggu persetujuan user
3. jangan langsung implementasi

Completion Validation
---------------------
- Sebelum menutup tugas, pastikan setiap perubahan telah diverifikasi terhadap kriteria yang disepakati dan dokumen `docs/`.
- Validasi bahwa tidak ada file baru atau perubahan yang melanggar struktur atau aturan governance.
- Catat hasil verifikasi dalam ringkasan pekerjaan.
- AI tidak boleh menyatakan: "selesai" jika:
  - struktur file belum lengkap
  - template wajib belum terisi
  - acceptance criteria belum terpenuhi
  - placeholder masih ada

Forbidden
---------
- Jangan menjalankan atau menyimpan kredensial, kunci, atau informasi sensitif.
- Jangan push langsung ke remote tanpa persetujuan eksplisit.
- Jangan mengubah arsitektur, database, atau kebijakan proyek tanpa persetujuan dan dokumentasi yang jelas.

Audit
-----
- Catat setiap perubahan yang dilakukan oleh agen dalam log commit/PR dan file ringkasan.

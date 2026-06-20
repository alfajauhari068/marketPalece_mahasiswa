# coding-standard.md

Purpose
-------
Standar penulisan kode untuk menjaga konsistensi, keterbacaan, dan maintainability.

Key Rules
---------
- Ikuti prinsip SOLID, DRY, KISS.
- Gunakan `snake_case` untuk database columns, `StudlyCase` untuk class, `camelCase` untuk method/variables.
- Maksimum fungsi ~ 50 baris; pecah jika kompleks.
- Hindari komentar berlebihan; beri nama yang eksplisit.
- Semua perubahan fungsional harus disertai unit test.

Formatting
----------
- PHP: gunakan PSR-12; jalankan `composer fix` / linter pada CI.

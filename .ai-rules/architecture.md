# architecture.md

Purpose
-------
Menetapkan pola arsitektur dan aturan modular untuk proyek agar konsisten dan mudah diskalakan.

Guidelines
----------
- Gunakan Modular Monolith (Laravel) sebagai pola default: `app/Modules/*` untuk fitur.
- Pisahkan lapisan: Presentation → Application Services → Domain → Infrastructure.
- Arah ketergantungan harus mengalir ke Shared/Domain, bukan sebaliknya.
- Fitur-modul tidak boleh bergantung langsung pada modul fitur lain; komunikasikan melalui `Shared` dan kontrak/domain abstractions.
- Gunakan service layer dan repository untuk akses DB pada modul kompleks.
- Semua aturan modul dan dependensi harus konsisten dengan `docs/` dan file aturan arsitektur.

Dependency Rules
---------------
Domain Layer:
Allowed:
- Entities
- Value Objects
- Interfaces
Forbidden:
- Eloquent
- Database Query
- Framework dependency

Infrastructure Layer:
Allowed:
- Eloquent
- Repositories
- Queue
- Storage
Forbidden:
- Business rules
- Domain entities
- Framework usage in domain interfaces

Layer Flow
----------
- `Presentation` dapat menggunakan `Application Services` dan `Shared`.
- `Application Services` dapat menggunakan `Domain`, `Shared`, dan `Infrastructure`.
- `Domain` dapat menggunakan `Shared`, tetapi bukan sebaliknya.
- `Infrastructure` dapat menggunakan `Domain` dan `Shared`, tetapi tidak boleh digunakan oleh `Presentation` secara langsung untuk logika bisnis.
- Hindari modul silang yang menyebabkan `Feature A` mengimpor implementasi `Feature B` secara langsung.

When to evolve
---------------
- Ekstraksi ke microservice untuk Chat dan Payments jika throughput meningkat.

# api-standard.md

Purpose
-------
Standarisasi endpoint API, format response, error handling, dan versi.

Standards
---------
- Base path: `/api/v1`.
- Use HTTP verbs correctly: GET/POST/PUT/PATCH/DELETE.
- Pagination meta: `current_page`, `per_page`, `total`.
- Error format: `{ error: { code, message, details? } }`.
- Use `Idempotency-Key` header for POST endpoints that create transactions.

Versioning
----------
- Increment major path (`/api/v2`) for breaking changes.

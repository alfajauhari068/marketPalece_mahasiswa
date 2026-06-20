# security.md

Purpose
-------
Pusat aturan keamanan aplikasi: authentication, authorization, input sanitization, dan operasional.

Essentials
----------
- Authentication: Laravel Sanctum for SPA/API tokens; HTTPS enforced.
- Authorization: policies & gates; `role` checks for admin actions.
- Input: validate and sanitize; escape outputs.
- CSRF: enable for web routes; require tokens for forms.
- File uploads: restrict mime type and size; store on disk with signed URLs.
- Logging: mask secrets; log security events to a secure sink.

Deployment
----------
- Rotate secrets, use env vars, restrict DB user privileges.

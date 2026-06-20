# SYSTEM CONTEXT

## Actors

1. Visitor
2. Buyer
3. Seller
4. Admin

---

## External Systems

Current:

- Database MySQL
- File Storage
- Email Notification

Future:

- Payment Gateway
- Websocket
- Mobile App API

---

## Main Modules

Authentication Module

↓

Profile Module

↓

Service Module

↓

Marketplace Module

↓

Order Module

↓

Payment Module

↓

Review Module

↓

Chat Module

↓

Admin Module

---

## Critical Rules

1. User tidak boleh membeli jasa sendiri

2. Order wajib:

- buyer_id
- seller_id
- service_id

3. State order:

pending
↓

diproses
↓

selesai

atau

pending
↓

dibatalkan

Tidak boleh:

pending → selesai

selesai → diproses

4. Review hanya setelah order selesai

5. Payment tidak boleh double submit

6. Chat minimal polling
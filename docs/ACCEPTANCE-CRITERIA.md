# ACCEPTANCE CRITERIA

## Authentication

### Register

Given user belum login

When mengisi data valid

Then akun berhasil dibuat

---

### Login

Given akun valid

When login

Then masuk dashboard

---

## Service

Given seller login

When input data valid

Then jasa muncul di marketplace

---

## Order

Given buyer login

When klik pesan

Then order dibuat dengan:

- buyer_id
- seller_id
- service_id
- status=pending

---

## Payment

Given order pending

When pembayaran berhasil

Then:

payment_status=paid

order_status=diproses

---

## Review

Given order selesai

When buyer memberi review

Then:

- rating tersimpan
- review tampil
- rating seller diperbarui

---

## Chat

Given user mengirim pesan

When submit

Then:

- pesan tersimpan
- status unread
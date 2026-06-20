# API SPECIFICATION

Base URL:

/api/v1

## Auth

POST /register

POST /login

POST /logout

GET /me

---

## Profile

GET /profile

PUT /profile

---

## Service

GET /services

GET /services/{id}

POST /services

PUT /services/{id}

DELETE /services/{id}

---

## Order

GET /orders

POST /orders

GET /orders/{id}

PUT /orders/{id}/status

---

## Payment

POST /payments

GET /payments/{id}

---

## Chat

GET /chats

POST /chats

---

## Review

POST /reviews

GET /reviews/{serviceId}

---

## Admin

GET /admin/users

GET /admin/services

GET /admin/orders
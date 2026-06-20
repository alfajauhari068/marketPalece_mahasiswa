# DATABASE SPECIFICATION

## users

|Field|Type|
|--|--|
id|bigint
name|string
email|string
password|string
role|enum
verified_at|timestamp

---

## profiles

|Field|Type|
|--|--|
id|bigint
user_id|FK
bio|text
skills|json
photo|string
rating_avg|decimal

---

## categories

|Field|Type|
|--|--|
id|bigint
name|string

---

## services

|Field|Type|
|--|--|
id|bigint
user_id|FK
title|string
description|text
price|decimal
category_id|FK
status|enum

---

## orders

|Field|Type|
|--|--|
id|bigint
buyer_id|FK
seller_id|FK
service_id|FK
status|enum
total_price|decimal

---

## order_details

|Field|Type|
|--|--|
id|bigint
order_id|FK
note|text

---

## payments

|Field|Type|
|--|--|
id|bigint
order_id|FK
method|string
status|enum
paid_at|timestamp

---

## chats

|Field|Type|
|--|--|
id|bigint
sender_id|FK
receiver_id|FK
message|text
is_read|boolean

---

## reviews

|Field|Type|
|--|--|
id|bigint
order_id|FK
reviewer_id|FK
rating|integer
comment|text
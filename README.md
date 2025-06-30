# 🧾 Stock & Transaction Management System

A PHP-based web application for managing inventory and transactions in real-time. Designed with a built-in locking mechanism to prevent data conflicts during multi-user access. Ideal for academic systems, small-scale retail operations, and internal inventory tools.

---

## 📌 Core Features
- **📦 Inventory Module**  
  Add, edit, delete product data (name, price, stock, image, etc.)
- **💳 Transaction Module**  
  Handle customer transactions with CRUD support
- **🔐 Multi-User Concurrency Locking**  
  Prevents simultaneous edits using `tbl_lock` logic
- **🧠 Clean UI/UX Dashboard**  
  Built with Bootstrap and AJAX for smooth user experience
- **🔍 Live Data Loading**  
  Efficient product display with dynamic `stok_data.php`

---

## 🗃 Database Overview

**Main Tables:**
- `tbl_admin`: Stores admin account data including username, password (hashed) and image.  
  Used for managing authentication and access control for users in the system.
- `tbl_stok`: Inventory details such as product name, description, price, stock quantity, image, and associated admin.
- `tbl_transaksi`: Records of all product transactions including product ID, quantity sold, transaction date, and the responsible admin.
- `tbl_lock`: Tracks lock status for specific records (whether it's being edited or added), along with who locked it and when — ensuring safe multi-user operations and preventing concurrent edits.
> Stored procedures, triggers, and transactions are embedded in the SQL schema to enforce business rules and data integrity at the database level.

---

## 🚀 How to Run

### 1. Clone This Repository
```bash
git clone https://github.com/your-username/stock-transaction-management.git
```
### 2. Import the Database
- Open `phpMyAdmin` or use terminal
- Import `db_webdailyjurnal.sql`
- Check tables `tbl_admin`, `tbl_stok`, `tbl_transaksi`, and `tbl_lock`
### 3. Run in Localhost
- Place folder in `htdocs` (XAMPP) or `www` (Laragon)
- Access via browser:
```
http://localhost/index.php
```
---

## 👨‍💻 Authors
This project is proudly built by:
- **Johana Oktavia Ramadhani**  
- **Chalida Abdat**  
- **Megan Febriana Putri Johana**
> Developed as part of academic fulfillment in **Database Systems Practice – 2025**.

---

> Built with ☕, teamwork, and a lot of debugging energy ⚡
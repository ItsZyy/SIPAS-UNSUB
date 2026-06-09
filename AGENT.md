# SIPAS UNSUB - AI Agent Context

## Project Name
SIPAS UNSUB (Sistem Informasi Pengarsipan Surat Berbasis Web untuk Universitas Subang)

## Tagline
Smart Letter Archiving System

---

## Tech Stack
- Laravel 12
- Blade Template
- Tailwind CSS
- MySQL
- Laravel Breeze (authentication)

---

## Project Purpose
Aplikasi ini digunakan untuk mengelola arsip surat dan dokumen digital di lingkungan Universitas Subang. Sistem mencakup pengelolaan surat masuk, surat keluar, serta dokumen berdasarkan kategori.

---

## User Roles
1. Admin
- Full access system
- Manage users
- Manage categories
- Manage all archives

2. Operator
- Add and edit archives
- Upload PDF files
- Search and filter archives
- Cannot manage users

---

## Core Features
- Authentication (login, register, logout)
- Dashboard statistics
- Category management
- Archive management (CRUD)
- PDF upload (scan results)
- Search and filter archives
- PDF preview & download

---

## Data Structure Concept
Archive:
- nomor_dokumen
- nama_dokumen
- jenis (masuk/keluar)
- category_id
- tanggal
- file_pdf
- keterangan

Category:
- nama

User:
- name
- email
- password
- role (admin/operator)

---

## UI Guidelines
- Use Tailwind CSS
- Clean and minimal dashboard
- Sidebar navigation
- Responsive layout
- Simple admin panel style

---

## Development Rules
- Build feature step-by-step
- One feature = one commit
- Do not mix multiple features in one task
- Always prioritize Laravel best practices
- Use controller, model, migration, request validation

---

## AI Agent Behavior
- Always assume this context is active
- Do not recreate authentication unless asked
- Focus on incremental development
- Keep code clean and production-like
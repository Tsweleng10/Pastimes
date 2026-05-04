# Pastimes – Second‑hand Clothing Web Application (Part 2)

A MySQL‑driven web application for buying and selling second‑hand branded clothing, built as part of the WEDE6021 Web Development (Intermediate) module.

## Table of Contents
- [Project Overview](#project-overview)
- [Folder Structure](#folder-structure)
- [Requirements](#requirements)
- [Setup Instructions](#setup-instructions)
  - [1. Install XAMPP (or equivalent)](#1-install-xampp-or-equivalent)
  - [2. Place the project files](#2-place-the-project-files)
  - [3. Create the database](#3-create-the-database)
  - [4. Load the database tables and data](#4-load-the-database-tables-and-data)
- [Usage](#usage)
  - [Login Credentials](#login-credentials)
  - [Key Pages](#key-pages)
- [Video Demonstration](#video-demonstration)
- [Troubleshooting](#troubleshooting)
- [Authors](#authors)

## Project Overview
Pastimes allows users to register, log in, and browse second‑hand clothing items. Administrators verify new users before they can access the system. The application uses object‑oriented PHP, MySQL, and a responsive CSS design. All data is stored in a MySQL database named `ClothingStore`.

## Folder Structure
pastimes/
│
├── css/
│ └── style.css # Styling for all pages
├── images/ # 20 product images (JPEG)
│ ├── winterBoots.jpeg
│ ├── beanie.jpeg
│ └── ... (20 files total)
│
├── DBConn.php # Database connection script
├── createTable.php # Creates tbl_user and loads userData.txt
├── createClothesTable.php # Creates tbl_clothes and loads clothesData.txt
├── loadClothingStore.php # Executes myClothingStore.sql (bulk setup)
├── userData.txt # Initial 5 users (tab‑separated)
├── clothesData.txt # All clothing items (tab‑separated)
├── myClothingStore.sql # Full database schema + 30 users & 30 clothes
│
├── index.php # Redirects to login.php
├── login.php # Login form + sticky form on error
├── register.php # New user registration (pending admin approval)
├── dashboard.php # "User X is logged in" + associative data table
├── admin.php # Admin panel – approve/delete users
├── products.php # Displays all available clothes in a table
├── logout.php # Destroys session and redirects to login
└── README.md # This file

## Requirements
- **XAMPP** (Apache + MySQL + PHP 8.x) or any LAMP/WAMP/MAMP stack.
- A modern web browser.
- The `ClothingStore` database (created in phpMyAdmin or via the scripts).

## Setup Instructions

### 1. Install XAMPP (or equivalent)
Download and install XAMPP from [apachefriends.org](https://www.apachefriends.org). Start the **Apache** and **MySQL** services.

### 2. Place the project files
Copy the entire `pastimes` folder into your web server's document root:
- XAMPP (macOS): `/Applications/XAMPP/htdocs/pastimes/`
- XAMPP (Windows): `C:\xampp\htdocs\pastimes\`
- MAMP: `/Applications/MAMP/htdocs/pastimes/`

### 3. Create the database
Open **phpMyAdmin** (`http://localhost/phpmyadmin`) and create a new, empty database called **`ClothingStore`**. Leave the collation as default.

### 4. Load the database tables and data

**Option A – Use the SQL file (recommended)**
1. Make sure the file `myClothingStore.sql` is inside the `pastimes` folder.
2. Open your browser and go to:  
   `http://localhost/pastimes/loadClothingStore.php`
3. You should see a success message. Both tables (`tbl_user` and `tbl_clothes`) are now created and populated with 30 rows each.

**Option B – Use the individual load scripts**
- Run `http://localhost/pastimes/createTable.php` to set up `tbl_user` (5 initial users).
- Then run `http://localhost/pastimes/createClothesTable.php` to create `tbl_clothes` and load all items from `clothesData.txt`.

> **Note:** The `myClothingStore.sql` file is **safe to run multiple times** – it uses `CREATE TABLE IF NOT EXISTS` and `INSERT IGNORE`, so it will never delete existing data.

## Usage

### Login Credentials

| Role  | Email                   | Password   |
|-------|-------------------------|------------|
| Admin | admin@pastimes.co.za    | admin      |
| Buyer | j.doe@abc.co.za         | password   |
| Buyer | jane.smith@xyz.co.za    | password1  |
| Seller| mike.b@coolmail.co.za   | 123        |

*All passwords are MD5‑hashed in the database for testing purposes.*

### Key Pages
- **Register** (`register.php`) – New users sign up. All fields required. Account stays unverified until admin approves.
- **Login** (`login.php`) – If password is wrong, the form keeps the email (sticky form). Successful login redirects to the dashboard.
- **Dashboard** (`dashboard.php`) – Displays “User [name] is logged in” and the user’s data in an associative table.
- **Admin Panel** (`admin.php`) – Admin can see all users, approve unverified buyers/sellers, and delete users.
- **Clothes** (`products.php`) – Shows all available items with image, title, description, and price.

## Video Demonstration
A screen recording (`video.mp4`) is included in the submission. It shows:
1. Running `createTable.php` to populate `tbl_user`.
2. Loading the full database with `loadClothingStore.php`.
3. Registering a new user.
4. Admin login and verification of the new user.
5. Logging in as the newly approved user.
6. Viewing clothes on the products page.

## Troubleshooting
- **Blank page?** Enable error reporting by adding `error_reporting(E_ALL); ini_set('display_errors', 1);` to the top of the problematic script.
- **Table doesn't exist?** Make sure you ran `loadClothingStore.php` or manually created the tables.
- **Foreign key error?** Tables must be created in the correct order: `tbl_user` first, then `tbl_clothes`.
- **Image not showing?** Check that the filename in the `image_path` column exactly matches the file in the `images/` folder (case‑sensitive on macOS).

## Authors
- Galane Raesibe Kate (ST10450352)
- Joshua Tsweleng (ST10451745)

Module: WEDE6021 – Web Development (Intermediate)  
Date: 14 April 2026

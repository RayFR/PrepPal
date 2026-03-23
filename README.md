# PrepPal

PrepPal is a full-stack Laravel e-commerce web application developed for the CS2TP coursework.  
It allows users to browse products, place orders, manage their account, and interact with a complete admin inventory and order management system.

Link to hosted site: http://cs2team26.cs2410-web01pvm.aston.ac.uk/

---

## Project Overview

**PrepPal** is an online platform designed to help users purchase meal plans and fitness-related products.

The system supports:
- Customer shopping experience
- Admin management system
- Inventory tracking
- Order processing

---

### Customer Features

- Register / Login / Logout
- Change password
- Browse products
- Search and filter products
- Add to cart / remove / update quantities
- Checkout with simulated payment
- View order history
- View order details
- Track order status (pending, processing, shipped, completed)
- Submit product reviews
- Update profile + profile picture
- Request return on orders

---

### Admin Features

- Admin-only access (middleware protected)
- View all customers
- Edit / delete customers
- Promote users to admin
- View all orders
- Update order status
- View return requests
- Manage inventory

---

### Inventory System

- Products stored in database
- Stock levels tracked per product
- Automatic stock reduction on checkout
- Stock indicators:
  - In stock
  - Low stock
  - Out of stock
- Admin can:
  - Add stock (incoming inventory)
  - Update stock levels
- Low stock alerts shown in UI

---

### Order System

- Orders stored with:
  - items
  - quantities
  - total price
- Order statuses:
  - pending
  - processing
  - shipped
  - completed
- Customers can view order history
- Customers can request returns

---

## Tech Stack

- **Backend:** Laravel (PHP)
- **Frontend:** Blade, HTML, CSS, JavaScript
- **Database:** MySQL
- **Tools:** Git, GitHub, VS Code

---

## Installation

Clone repository:
```bash
git clone <your-repo-url>
cd preppal
```

Install dependencies:
```bash
composer install
npm install
```

Setup environment:
```bash
cp .env.example .env
php artisan key:generate
Configure database in .env
```

Run migrations:
```bash
php artisan migrate
```

Seed products:
```bash
php artisan db:seed --class=ProductSeeder
```

Run server:
```bash
php artisan serve
```

# Sales Inventory Management System

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-00758F?style=flat-square&logo=mysql)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

A comprehensive and professional web-based Sales and Inventory Management System built with Laravel 11. This system provides complete CRUD operations for managing products, customers, invoices, and generating detailed sales reports with PDF export functionality.

## 📋 Table of Contents

- [Features](#-features)
- [Technology Stack](#-technology-stack)
- [System Requirements](#-system-requirements)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Usage Guide](#-usage-guide)
- [Project Structure](#-project-structure)
- [API Endpoints](#-api-endpoints)
- [Database Schema](#-database-schema)
- [Authentication](#-authentication)
- [Troubleshooting](#-troubleshooting)
- [Contributing](#-contributing)
- [License](#-license)
- [Author](#-author)

## ✨ Features

### User Management
- User registration with email verification
- OTP-based email verification
- Secure login authentication
- Password reset functionality
- Profile management with password verification
- JWT token-based authentication

### Customer Management
- Create, read, update, delete customers
- Customer contact information (email, phone)
- DataTables integration for easy browsing
- Customer search and filtering

### Product Management
- Complete CRUD operations for products
- Category-based organization
- Product image upload and management
- Unit and pricing information
- Real-time product availability
- Quick product search

### Invoice & Sales Management
- Create professional invoices
- Multiple products per invoice
- Automatic calculation of totals, VAT (5%), and discounts
- Invoice viewing with detailed breakdown
- Invoice printing to PDF
- Invoice deletion with confirmation
- Invoice history tracking

### Sales Reporting
- Generate sales reports by date range
- PDF report download
- Detailed invoice breakdown
- Financial summaries (total, VAT, discount, payable)
- Support for multiple download methods (Chrome, Firefox, IDM)

### Dashboard
- Real-time business metrics overview
- Summary of products, categories, customers
- Invoice and sales statistics
- At-a-glance financial information

## 🛠️ Technology Stack

### Backend
- **Framework:** Laravel 11
- **PHP Version:** 8.2+
- **Database:** MySQL 5.7+ / MariaDB
- **Authentication:** Custom JWT Token System
- **PDF Generation:** Barryvdh/DomPDF
- **Testing:** Pest PHP

### Frontend
- **Template Engine:** Blade
- **CSS Framework:** Bootstrap 5
- **HTTP Client:** Axios
- **DOM Manipulation:** jQuery 3.6+
- **Data Tables:** DataTables
- **Notifications:** Toastify
- **Icons:** Bootstrap Icons

### Development Tools
- **Task Runner:** Laravel Mix
- **Package Manager:** Composer, npm
- **Version Control:** Git

## 📋 System Requirements

- **PHP:** 8.2 or higher
- **Database:** MySQL 5.7+ or MariaDB 10.3+
- **Web Server:** Apache with mod_rewrite or Nginx
- **Memory:** Minimum 512MB recommended
- **Disk Space:** Minimum 100MB
- **Composer:** Latest version
- **Node.js & npm:** For asset compilation

## 🚀 Installation

### Step 1: Clone Repository
```bash
git clone https://github.com/mdSoroarJahan/Sales-Inventory.git
cd Sales-Inventory/Sales-Inventory-Project
```

### Step 2: Install Dependencies
```bash
composer install
npm install
```

### Step 3: Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### Step 4: Configure Database
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sales_inventory
DB_USERNAME=root
DB_PASSWORD=
```

Create database:
```bash
mysql -u root -e "CREATE DATABASE sales_inventory;"
```

### Step 5: Run Migrations & Seeders
```bash
php artisan migrate
php artisan migrate:seed
```

### Step 6: Create Storage Link
```bash
php artisan storage:link
```

### Step 7: Start Development Server
```bash
# Terminal 1: Backend
php artisan serve

# Terminal 2: Frontend assets
npm run dev
```

Access the application at `http://localhost:8000`

## ⚙️ Configuration

### Mail Configuration (OTP)
Update `.env`:
```env
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Sales Inventory"
```

### Storage Configuration
Ensure storage and public directories are writable:
```bash
chmod -R 775 storage bootstrap/cache
```

## 📖 Usage Guide

### Login/Registration
1. Navigate to login page
2. Click "Register" for new account
3. Enter email and password
4. Verify email with OTP
5. Complete registration and login

### Managing Products
1. Go to **Product** menu
2. Click **Create** button
3. Upload product image
4. Fill in details (name, price, unit, category)
5. Save product
6. Edit or delete from product list

### Managing Customers
1. Navigate to **Customer** menu
2. Click **Create** to add new customer
3. Enter customer details
4. Save in database
5. Edit or delete as needed

### Creating Invoices
1. Click **Create Sale**
2. Select customer from list
3. Add products (click Add button)
4. Enter quantity for each product
5. Apply discount percentage (optional)
6. Review calculations
7. Click **Confirm** to create invoice

### Managing Invoices
1. Go to **Invoice** menu
2. View all invoices in table
3. **View:** Click View button to see details
4. **Print:** Click Print button for PDF
5. **Delete:** Click Delete to remove

### Generating Reports
1. Navigate to **Report** menu
2. Select date range
3. Click **Download**
4. PDF generates automatically
5. Works with Chrome default, Firefox, IDM

## 📁 Project Structure

```
Sales-Inventory-Project/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── UserController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── CustomerController.php
│   │   │   ├── ProductController.php
│   │   │   ├── InvoiceController.php
│   │   │   ├── ReportController.php
│   │   │   ├── DashboardController.php
│   │   │   └── SaleController.php
│   │   └── Middleware/
│   │       └── TokenVerify.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Category.php
│   │   ├── Customer.php
│   │   ├── Product.php
│   │   ├── Invoice.php
│   │   └── InvoiceProduct.php
│   → Helper/
│   │   └── JWTToken.php
│   └── Mail/
│       └── OTPMail.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── components/
│   │   ├── layouts/
│   │   └── pages/
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php
│   └── console.php
├── public/
│   ├── css/
│   ├── js/
│   ├── images/
│   └── uploads/
├── storage/
│   ├── app/
│   ├── logs/
│   └── uploads/
└── tests/
    ├── Feature/
    └── Unit/
```

## 🔌 API Endpoints

### Authentication Routes
- `POST /user-registration` - Register new user
- `POST /user-login` - Login user
- `POST /send-otp` - Send OTP to email
- `POST /verify-otp` - Verify OTP code
- `POST /reset-password` - Reset password
- `GET /logout` - Logout (Protected)

### User Routes (Protected)
- `GET /user-profile` - Get user details
- `POST /user-profile-update` - Update profile

### Category Routes (Protected)
- `GET /category-list` - List categories
- `POST /category-create` - Create category
- `POST /categoryById` - Get category details
- `POST /category-update` - Update category
- `POST /category-delete` - Delete category

### Customer Routes (Protected)
- `GET /customer-list` - List customers
- `POST /customer-create` - Create customer
- `GET /customer-by-id` - Get customer details
- `POST /customer-update` - Update customer
- `DELETE /customer-delete` - Delete customer

### Product Routes (Protected)
- `GET /product-list` - List products
- `POST /product-create` - Create product
- `POST /product-by-id` - Get product
- `POST /product-update` - Update product
- `POST /product-delete` - Delete product

### Invoice Routes (Protected)
- `POST /invoice-create` - Create invoice
- `GET /invoice-select` - List invoices
- `POST /invoice-details` - Get invoice details
- `POST /invoice-delete` - Delete invoice

### Report Routes (Protected)
- `GET /sales-report/{FromDate}/{ToDate}` - Download PDF report
- `GET /summary` - Get dashboard summary

## 🗄️ Database Schema

### Users Table
```
id, name, email, phone, password, otp, otp_created_at, timestamps
```

### Customers Table
```
id, user_id(FK), name, email, mobile, timestamps
```

### Categories Table
```
id, user_id(FK), name, timestamps
```

### Products Table
```
id, user_id(FK), category_id(FK), name, price, unit, img_url, timestamps
```

### Invoices Table
```
id, user_id(FK), customer_id(FK), total, discount, vat, payable, timestamps
```

### Invoice Products Table
```
id, invoice_id(FK), user_id(FK), product_id(FK), qty, sale_price, timestamps
```

## 🔐 Authentication

The application uses custom header-based token authentication:
- User login generates unique token
- Token stored in browser localStorage
- All API requests include `user_id` header with token
- Middleware `token.verify` validates all protected routes

## 🐛 Troubleshooting

### Issue: Blank PDF Downloads in Chrome
**Solution:** System now uses form submission method which works with all browsers

### Issue: Images Not Displaying
**Solution:** Run `php artisan storage:link` and ensure directory is writable

### Issue: OTP Not Sent
**Solution:** Check mail configuration in `.env` and verify SMTP credentials

### Issue: 404 Errors on Routes
**Solution:** Run `php artisan route:cache`

### Issue: Database Connection Error
**Solution:** Verify `.env` database credentials and ensure MySQL is running

### Issue: Permission Denied Error
**Solution:** Run `chmod -R 775 storage bootstrap/cache`

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## 📄 License

This project is licensed under the MIT License - see LICENSE file for details.

## 👤 Author

**Md Soroar Jahan**
- GitHub: [@mdSoroarJahan](https://github.com/mdSoroarJahan)
- Email: [soroarjahan17@example.com]

## 🙏 Acknowledgments

- Laravel Framework and Team
- Barryvdh/DomPDF
- Bootstrap Framework
- Axios HTTP Client
- jQuery & DataTables
- All open-source contributors

---

<div align="center">

**Made with ❤️ by Md Soroar Jahan**

[⬆ back to top](#sales-inventory-management-system)

</div>

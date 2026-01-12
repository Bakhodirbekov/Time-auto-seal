# InsofAuto - Car Marketplace System

## Project Overview
InsofAuto is a full-stack car marketplace platform with:
- **Backend**: Laravel 10 REST API
- **Frontend**: React (Vite)
- **Authentication**: Laravel Sanctum (JWT-like tokens)
- **Database**: MySQL
- **Key Feature**: 24-hour countdown timer for car listings

---

## 📋 Table of Contents
1. [Installation](#installation)
2. [Backend Setup](#backend-setup)
3. [Frontend Setup](#frontend-setup)
4. [API Documentation](#api-documentation)
5. [Timer Logic](#timer-logic)
6. [Authentication Flow](#authentication-flow)
7. [Admin Panel](#admin-panel)
8. [Deployment](#deployment)

---

## 🚀 Installation

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js >= 16
- MySQL >= 5.7
- Git

---

## 🔧 Backend Setup

### 1. Navigate to Backend Directory
```bash
cd Backend
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Configuration
```bash
# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=insofauto
DB_USERNAME=root
DB_PASSWORD=your_password

# Timer Configuration
CAR_TIMER_DURATION=24

# Frontend URL for CORS
FRONTEND_URL=http://localhost:3000
SANCTUM_STATEFUL_DOMAINS=localhost:3000,127.0.0.1:3000
```

### 5. Run Migrations & Seeders
```bash
# Create database first in MySQL
# CREATE DATABASE insofauto;

# Run migrations
php artisan migrate

# Seed database with initial data
php artisan db:seed
```

### 6. Create Storage Link
```bash
php artisan storage:link
```

### 7. Start Development Server
```bash
php artisan serve
```

Server runs at: `http://localhost:8000`

### 8. Start Queue & Scheduler (Required for Timer)
```bash
# In a new terminal - Start scheduler (for timer expiration)
php artisan schedule:work

# Or add to cron (production):
# * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## ⚛️ Frontend Setup

### 1. Navigate to Frontend Directory
```bash
cd Frond
```

### 2. Install Dependencies
```bash
npm install
```

### 3. Configure Environment
Create `.env` file in `Frond` directory:
```env
VITE_API_URL=http://localhost:8000/api
VITE_APP_NAME=InsofAuto
```

### 4. Start Development Server
```bash
npm run dev
```

Frontend runs at: `http://localhost:3000`

---

## 📚 API Documentation

### Base URL
```
http://localhost:8000/api
```

### Authentication Headers
For protected routes, include:
```
Authorization: Bearer {token}
Accept: application/json
Content-Type: application/json
```

---

## 🔐 Authentication Endpoints

### 1. User Registration
```http
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "phone": "+998901234567",
  "address": "Tashkent, Uzbekistan"
}

Response:
{
  "message": "User registered successfully",
  "user": {...},
  "access_token": "token_here",
  "token_type": "Bearer"
}
```

### 2. User Login
```http
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}

Response:
{
  "message": "Login successful",
  "user": {...},
  "access_token": "token_here",
  "token_type": "Bearer"
}
```

### 3. Admin Login
```http
POST /api/admin/login
Content-Type: application/json

{
  "email": "admin@insofauto.com",
  "password": "admin123"
}

Response:
{
  "message": "Admin login successful",
  "user": {...},
  "access_token": "token_here"
}
```

### 4. Logout
```http
POST /api/logout
Authorization: Bearer {token}

Response:
{
  "message": "Logout successful"
}
```

### 5. Get Current User
```http
GET /api/me
Authorization: Bearer {token}

Response:
{
  "user": {...}
}
```

---

## 🚗 Car Endpoints

### 1. List Cars (Public)
```http
GET /api/cars?page=1&per_page=15&category_id=1&search=toyota&min_price=5000&max_price=50000

Response:
{
  "data": [...],
  "current_page": 1,
  "total": 100,
  ...
}
```

### 2. Get Single Car
```http
GET /api/cars/{id}

Response:
{
  "id": 1,
  "title": "Toyota Camry 2020",
  "price": 25000,
  "price_visible": true,
  "timer_end_at": "2026-01-12T10:30:00Z",
  "remaining_time": 3600,
  "timer_expired_status": false,
  ...
}
```

### 3. Hot Deals
```http
GET /api/cars/hot-deals?page=1

Response:
{
  "data": [...],
  ...
}
```

### 4. Create Car Listing (Protected)
```http
POST /api/cars
Authorization: Bearer {token}
Content-Type: multipart/form-data

FormData:
- category_id: 1
- subcategory_id: 2
- title: "Toyota Camry 2020"
- description: "Excellent condition"
- price: 25000
- brand: "Toyota"
- model: "Camry"
- year: 2020
- color: "Black"
- mileage: 50000
- fuel_type: "Gasoline"
- transmission: "Automatic"
- condition: "Used"
- location: "Tashkent"
- images[]: file1.jpg
- images[]: file2.jpg

Response:
{
  "message": "Car listing created successfully. Waiting for admin approval.",
  "car": {...}
}
```

### 5. Update Car
```http
PUT /api/cars/{id}
Authorization: Bearer {token}

{
  "title": "Updated Title",
  "price": 26000
}

Response:
{
  "message": "Car updated successfully",
  "car": {...}
}
```

### 6. Delete Car
```http
DELETE /api/cars/{id}
Authorization: Bearer {token}

Response:
{
  "message": "Car deleted successfully"
}
```

### 7. My Cars
```http
GET /api/my-cars
Authorization: Bearer {token}

Response:
{
  "data": [...],
  ...
}
```

---

## ❤️ Favorites Endpoints

### 1. Get Favorites
```http
GET /api/favorites
Authorization: Bearer {token}
```

### 2. Add to Favorites
```http
POST /api/favorites
Authorization: Bearer {token}

{
  "car_id": 1
}
```

### 3. Remove from Favorites
```http
DELETE /api/favorites/{carId}
Authorization: Bearer {token}
```

### 4. Check if Favorite
```http
GET /api/favorites/check/{carId}
Authorization: Bearer {token}

Response:
{
  "is_favorite": true
}
```

---

## 📂 Category Endpoints

### 1. List Categories
```http
GET /api/categories

Response:
[
  {
    "id": 1,
    "name": "Sedan",
    "slug": "sedan",
    "subcategories": [...]
  }
]
```

---

## 🚨 Complaint Endpoints

### 1. Submit Complaint
```http
POST /api/complaints
Authorization: Bearer {token}

{
  "car_id": 1,
  "subject": "Fake listing",
  "message": "This car doesn't exist"
}
```

---

## 🔔 Notification Endpoints

### 1. Get Notifications
```http
GET /api/notifications
Authorization: Bearer {token}
```

### 2. Unread Count
```http
GET /api/notifications/unread-count
Authorization: Bearer {token}

Response:
{
  "count": 5
}
```

### 3. Mark as Read
```http
POST /api/notifications/{id}/read
Authorization: Bearer {token}
```

### 4. Mark All as Read
```http
POST /api/notifications/read-all
Authorization: Bearer {token}
```

---

## 👨‍💼 Admin API Endpoints

**All admin routes require authentication and admin/moderator role**

Base: `/api/admin`

### Dashboard
```http
GET /api/admin/dashboard
GET /api/admin/dashboard/stats
```

### Car Management
```http
GET /api/admin/cars
GET /api/admin/cars/pending
GET /api/admin/cars/{id}
PUT /api/admin/cars/{id}
DELETE /api/admin/cars/{id}
POST /api/admin/cars/{id}/approve
POST /api/admin/cars/{id}/reject
POST /api/admin/cars/{id}/toggle-hot-deal
POST /api/admin/cars/{id}/start-timer
POST /api/admin/cars/{id}/expire-timer
```

### User Management (Admin Only)
```http
GET /api/admin/users
GET /api/admin/users/{id}
POST /api/admin/users/{id}/block
POST /api/admin/users/{id}/unblock
PUT /api/admin/users/{id}/role
```

### Category Management
```http
GET /api/admin/categories
POST /api/admin/categories
PUT /api/admin/categories/{id}
DELETE /api/admin/categories/{id}

POST /api/admin/subcategories
PUT /api/admin/subcategories/{id}
DELETE /api/admin/subcategories/{id}
```

### Complaint Management
```http
GET /api/admin/complaints
GET /api/admin/complaints/{id}
POST /api/admin/complaints/{id}/resolve
POST /api/admin/complaints/{id}/reject
```

### Settings (Admin Only)
```http
GET /api/admin/settings
PUT /api/admin/settings
```

---

## ⏱️ Timer Logic Explanation

### How It Works

1. **Car Creation**: When admin approves a car, a 24-hour timer starts automatically
   - `posted_at` = current timestamp
   - `timer_end_at` = current timestamp + 24 hours
   - `timer_expired` = false
   - `price_visible` = false

2. **Price Visibility**: During timer period (24 hours)
   - Car is visible to all users
   - Price is HIDDEN (`price_visible = false`)
   - Users can see all details except price
   - Timer countdown is shown

3. **Timer Expiration**: After 24 hours
   - Cron job runs every minute: `php artisan cars:expire-timers`
   - Finds cars where `timer_end_at <= now()` and `timer_expired = false`
   - Updates: `timer_expired = true`, `price_visible = true`
   - Sends notification to car owner

4. **Manual Timer Control** (Admin only)
   - Start timer: `POST /api/admin/cars/{id}/start-timer`
   - Expire timer manually: `POST /api/admin/cars/{id}/expire-timer`
   - Configure duration: `timer_duration` parameter (hours)

### Configuration
In `.env`:
```env
CAR_TIMER_DURATION=24  # Hours
```

### Cron Setup (Production)
Add to crontab:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🔒 Authentication Flow

### User Registration/Login Flow
1. User submits credentials to `/api/register` or `/api/login`
2. Backend validates and creates/finds user
3. Backend generates Sanctum token
4. Frontend stores token in localStorage/sessionStorage
5. Frontend includes token in Authorization header for protected routes

### Admin Authentication
- Same as user but uses `/api/admin/login`
- Backend checks if user role is 'admin' or 'moderator'
- Only grants access if role matches

### Middleware Protection
- `auth:sanctum` - Requires valid token
- `role:admin,moderator` - Requires specific role

---

## 🖥️ Admin Panel

The admin panel is accessible via API routes. You can build a separate React admin interface or use the existing React app with role-based routing.

### Default Admin Credentials
```
Email: admin@insofauto.com
Password: admin123

Email: moderator@insofauto.com
Password: moderator123
```

### Admin Capabilities
- ✅ View dashboard with statistics
- ✅ Approve/Reject car listings
- ✅ Manage categories and subcategories
- ✅ Control timers manually
- ✅ Mark cars as "Hot Deals"
- ✅ Manage users (block/unblock, change roles)
- ✅ Handle complaints
- ✅ Configure system settings

---

## 🔐 Security Features

1. **Password Hashing**: Bcrypt hashing via Laravel
2. **Token Authentication**: Laravel Sanctum
3. **Role-Based Access Control**: Middleware protection
4. **Input Validation**: Request validation on all inputs
5. **CSRF Protection**: Built-in Laravel CSRF
6. **SQL Injection Prevention**: Eloquent ORM
7. **XSS Protection**: Laravel's Blade escaping
8. **Blocked User Detection**: Middleware checks

---

## 📦 Database Schema

### Users Table
- id, name, email, password, phone, address
- role (admin/moderator/user)
- is_blocked, timestamps

### Cars Table
- id, user_id, category_id, subcategory_id
- title, description, price, price_visible
- brand, model, year, color, mileage
- fuel_type, transmission, condition, location
- status (pending/approved/rejected/sold)
- is_hot_deal, is_featured
- posted_at, timer_end_at, timer_expired
- timestamps, soft deletes

### Categories & Subcategories
- Categories: id, name, slug, description, icon, order
- Subcategories: id, category_id, name, slug, order

### Other Tables
- car_images, favorites, complaints, notifications, settings

---

## 🚀 Deployment

### Backend Deployment
1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Run `composer install --optimize-autoloader --no-dev`
4. Run `php artisan config:cache`
5. Run `php artisan route:cache`
6. Setup cron job for scheduler
7. Configure web server (Nginx/Apache)

### Frontend Deployment
1. Update `VITE_API_URL` to production API URL
2. Run `npm run build`
3. Deploy `dist` folder to web server
4. Configure SPA routing (redirect all to index.html)

---

## 🧪 Testing

### Test User Accounts (from seed)
```
Admin:
Email: admin@insofauto.com
Password: admin123

Moderator:
Email: moderator@insofauto.com
Password: moderator123

User:
Email: user@insofauto.com
Password: user123
```

---

## 📝 Important Notes

1. **Timer Cron**: Make sure scheduler is running for timer expiration
2. **Storage Link**: Run `php artisan storage:link` for image uploads
3. **CORS**: Configure CORS in `config/cors.php` for frontend
4. **File Uploads**: Max 10 images per car (configurable in settings)
5. **Sanctum**: Configure stateful domains for SPA authentication

---

## 🛠️ Troubleshooting

### Timer Not Expiring
```bash
# Check if scheduler is running
php artisan schedule:work

# Manually trigger timer expiration
php artisan cars:expire-timers
```

### CORS Issues
- Check `SANCTUM_STATEFUL_DOMAINS` in `.env`
- Verify `config/cors.php` settings
- Clear config cache: `php artisan config:clear`

### Authentication Errors
- Check token in localStorage
- Verify Authorization header format: `Bearer {token}`
- Check user is not blocked

---

## 📞 Support

For issues or questions about the system, check:
- API responses for error messages
- Laravel logs: `storage/logs/laravel.log`
- Browser console for frontend errors

---

## 🎉 Features Summary

✅ Full REST API with Laravel
✅ JWT-like authentication with Sanctum
✅ 24-hour countdown timer system
✅ Role-based access (Admin/Moderator/User)
✅ Car listings with approval workflow
✅ Hot Deals feature
✅ Favorites system
✅ Complaint management
✅ Notifications
✅ Image uploads
✅ Advanced filtering & search
✅ Responsive admin panel
✅ Mobile-first React frontend

---

**InsofAuto** - Built with ❤️ using Laravel & React

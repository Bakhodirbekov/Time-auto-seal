# InsofAuto - Quick Start Guide

## 🚀 Quick Setup (5 Minutes)

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL
- Node.js >= 16
- Git

---

## Backend Setup

### 1. Install Laravel Backend

```bash
# Navigate to Backend directory
cd Backend

# Install PHP dependencies
composer install

# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env
# DB_DATABASE=insofauto
# DB_USERNAME=root
# DB_PASSWORD=your_password
```

### 2. Create Database

```sql
CREATE DATABASE insofauto;
```

### 3. Run Migrations & Seed Data

```bash
# Run migrations
php artisan migrate

# Seed database with default data
php artisan db:seed

# Create storage link for images
php artisan storage:link
```

### 4. Start Backend Server

```bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Start scheduler (for timer system)
php artisan schedule:work
```

**Backend runs at**: `http://localhost:8000`

---

## Frontend Setup

### 1. Install React Frontend

```bash
# Navigate to frontend directory
cd Frond

# Install dependencies
npm install

# Install Axios for API calls
npm install axios
```

### 2. Configure Environment

Create `.env` file in `Frond` directory:
```env
VITE_API_URL=http://localhost:8000/api
VITE_APP_NAME=InsofAuto
```

### 3. Start Frontend Server

```bash
npm run dev
```

**Frontend runs at**: `http://localhost:5173`

---

## 🧪 Test the System

### Default Login Credentials

**Admin Account:**
```
Email: admin@insofauto.com
Password: admin123
```

**Moderator Account:**
```
Email: moderator@insofauto.com
Password: moderator123
```

**User Account:**
```
Email: user@insofauto.com
Password: user123
```

---

## 🔥 Key Features to Test

### 1. User Registration & Login
- Open frontend at `http://localhost:5173`
- Click "Sign In" or "Register"
- Create new account or use test accounts

### 2. Browse Cars
- View all car listings
- Filter by category, price, year
- Search for cars

### 3. Create Car Listing (User)
- Login as user
- Click "Sell Your Car"
- Fill in car details and upload images
- Submit listing (will be pending approval)

### 4. Admin Panel
- Login with admin credentials
- Access admin dashboard
- Approve/Reject pending car listings
- When approved, 24-hour timer starts automatically
- Price is hidden until timer expires

### 5. Timer System
- After admin approves car, timer starts (24 hours)
- Car is visible but price is HIDDEN
- After 24 hours, cron job expires timer
- Price becomes visible to all users

### 6. Hot Deals
- Admin can mark cars as "Hot Deal"
- View hot deals section

### 7. Favorites
- Add cars to favorites
- View favorites list

---

## 📡 API Testing (Optional)

### Test with Postman/Insomnia

**Base URL:** `http://localhost:8000/api`

### 1. Login
```http
POST http://localhost:8000/api/login
Content-Type: application/json

{
  "email": "user@insofauto.com",
  "password": "user123"
}
```

Response will include `access_token` - use this for authenticated requests.

### 2. Get Cars
```http
GET http://localhost:8000/api/cars?page=1&per_page=15
```

### 3. Get Single Car
```http
GET http://localhost:8000/api/cars/1
```

### 4. Get Favorites (Authenticated)
```http
GET http://localhost:8000/api/favorites
Authorization: Bearer {your_token_here}
```

---

## ⏱️ Understanding the Timer System

### Timer Flow:

1. **User creates car listing** → Status: `pending`

2. **Admin approves car** → System automatically:
   - Sets `status = 'approved'`
   - Sets `posted_at = now()`
   - Sets `timer_end_at = now() + 24 hours`
   - Sets `price_visible = false`
   - Sets `timer_expired = false`

3. **During 24 hours**:
   - Car is visible in listings
   - All details visible EXCEPT price
   - Timer countdown shown to users

4. **After 24 hours**:
   - Cron job runs: `php artisan cars:expire-timers`
   - System sets `timer_expired = true`
   - System sets `price_visible = true`
   - User receives notification

### Timer Configuration

In `Backend/.env`:
```env
CAR_TIMER_DURATION=24  # hours
```

### Manual Timer Control (Admin)

```http
# Start timer manually
POST http://localhost:8000/api/admin/cars/{id}/start-timer
Authorization: Bearer {admin_token}
{
  "hours": 48
}

# Expire timer manually
POST http://localhost:8000/api/admin/cars/{id}/expire-timer
Authorization: Bearer {admin_token}
```

---

## 🛠️ Troubleshooting

### Issue: Timer not expiring

**Solution:**
```bash
# Make sure scheduler is running
php artisan schedule:work

# Or manually trigger
php artisan cars:expire-timers
```

### Issue: CORS errors in browser console

**Solution:**
- Check `.env` in Backend:
```env
FRONTEND_URL=http://localhost:5173
SANCTUM_STATEFUL_DOMAINS=localhost:5173,127.0.0.1:5173
```

### Issue: 401 Unauthorized

**Solution:**
- Check if token is stored in localStorage
- Check Authorization header: `Bearer {token}`
- Verify user is not blocked

### Issue: Images not displaying

**Solution:**
```bash
cd Backend
php artisan storage:link
```

### Issue: Database errors

**Solution:**
```bash
# Clear and rebuild database
php artisan migrate:fresh --seed
```

---

## 🎯 Next Steps

### 1. Customize Categories
```bash
# Edit database/seeders/CategorySeeder.php
# Then run:
php artisan db:seed --class=CategorySeeder
```

### 2. Adjust Timer Duration
```bash
# Edit Backend/.env
CAR_TIMER_DURATION=48  # Change to desired hours
```

### 3. Configure Email Notifications
```bash
# Edit Backend/.env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
```

### 4. Upload Car Images
- Max 10 images per car
- Supported formats: JPEG, PNG, JPG, GIF
- Max size: 2MB per image

---

## 📱 Mobile Testing

Frontend is mobile-first with:
- Responsive design
- Bottom navigation bar
- Touch-friendly UI
- Swipeable image galleries

Test on mobile by:
1. Access from mobile device: `http://your-ip:5173`
2. Or use browser developer tools (F12) → Toggle device toolbar

---

## 🔒 Security Notes

1. **Change Default Passwords** before deploying to production
2. **Update Admin Email** in UserSeeder
3. **Configure Sanctum** for production domain
4. **Set APP_DEBUG=false** in production
5. **Use HTTPS** in production

---

## 📊 Database Tables

The system creates these tables:
- `users` - User accounts
- `cars` - Car listings
- `categories` - Car categories
- `subcategories` - Category subcategories
- `car_images` - Car photos
- `favorites` - User favorites
- `complaints` - User complaints
- `notifications` - User notifications
- `settings` - System settings

---

## 🎉 You're All Set!

Your InsofAuto car marketplace is now running with:

✅ Full REST API
✅ User authentication
✅ Admin panel
✅ 24-hour timer system
✅ Car listings with approval workflow
✅ Hot deals feature
✅ Favorites system
✅ Notifications
✅ Image uploads
✅ Mobile-first React frontend

---

## 📞 Need Help?

Check the full documentation: [DOCUMENTATION.md](./DOCUMENTATION.md)

Common commands:
```bash
# Backend
php artisan serve                  # Start server
php artisan schedule:work          # Start scheduler
php artisan cars:expire-timers     # Manually expire timers
php artisan migrate:fresh --seed   # Reset database

# Frontend
npm run dev                        # Start dev server
npm run build                      # Build for production
```

---

**Happy coding! 🚗💨**

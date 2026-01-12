# InsofAuto - Installation Checklist ✅

Use this checklist to ensure proper installation and configuration.

## 📋 Pre-Installation

- [ ] PHP 8.1 or higher installed
- [ ] Composer installed
- [ ] MySQL 5.7 or higher installed
- [ ] Node.js 16 or higher installed
- [ ] npm or yarn installed
- [ ] Git installed (optional)
- [ ] Text editor (VS Code recommended)

---

## 🔧 Backend Installation

### 1. Database Setup
- [ ] MySQL server is running
- [ ] Created database: `CREATE DATABASE insofauto;`
- [ ] Database username and password ready

### 2. Laravel Setup
- [ ] Navigated to `Backend` directory
- [ ] Ran `composer install`
- [ ] Copied `.env.example` to `.env`
- [ ] Ran `php artisan key:generate`
- [ ] Configured database in `.env`:
  - [ ] Set `DB_DATABASE=insofauto`
  - [ ] Set `DB_USERNAME=root`
  - [ ] Set `DB_PASSWORD=your_password`
- [ ] Set `FRONTEND_URL=http://localhost:5173` in `.env`
- [ ] Set `CAR_TIMER_DURATION=24` in `.env`

### 3. Database Migration
- [ ] Ran `php artisan migrate`
- [ ] Ran `php artisan db:seed`
- [ ] Verified tables created in MySQL
- [ ] Ran `php artisan storage:link`

### 4. Test Backend
- [ ] Started server: `php artisan serve`
- [ ] Opened browser: `http://localhost:8000`
- [ ] Saw Laravel welcome page or response
- [ ] Started scheduler: `php artisan schedule:work` (in new terminal)
- [ ] Tested timer command: `php artisan cars:expire-timers`

---

## ⚛️ Frontend Installation

### 1. Dependencies
- [ ] Navigated to `Frond` directory
- [ ] Ran `npm install`
- [ ] Installed axios: `npm install axios`
- [ ] No errors during installation

### 2. Environment Configuration
- [ ] Created `.env` file in `Frond` directory
- [ ] Added `VITE_API_URL=http://localhost:8000/api`
- [ ] Added `VITE_APP_NAME=InsofAuto`

### 3. Test Frontend
- [ ] Ran `npm run dev`
- [ ] Opened browser: `http://localhost:5173`
- [ ] Saw InsofAuto homepage
- [ ] No console errors in browser DevTools

---

## 🧪 System Testing

### Authentication Test
- [ ] Clicked "Sign In" on frontend
- [ ] Logged in with `user@insofauto.com` / `user123`
- [ ] Successfully logged in (saw user profile)
- [ ] Logged out successfully

### Admin Test
- [ ] Logged in with `admin@insofauto.com` / `admin123`
- [ ] Accessed admin panel/dashboard
- [ ] Saw statistics (cars, users, etc.)

### Car Listing Test
- [ ] As user, clicked "Sell Your Car" or similar
- [ ] Filled in car details
- [ ] Uploaded at least one image
- [ ] Submitted listing
- [ ] Listing status shows "Pending"

### Admin Approval Test
- [ ] As admin, viewed pending cars
- [ ] Approved a car listing
- [ ] Timer started (24 hours countdown)
- [ ] Price is hidden from public view

### Timer Test
- [ ] Backend scheduler is running: `php artisan schedule:work`
- [ ] Manually expired a timer: `php artisan cars:expire-timers`
- [ ] Or waited for timer to expire naturally
- [ ] Price became visible after expiration
- [ ] User received notification

### API Test (Optional)
- [ ] Used Postman/Insomnia
- [ ] Tested `POST http://localhost:8000/api/login`
- [ ] Received token in response
- [ ] Tested authenticated endpoint with token
- [ ] Got successful response

---

## 🔍 Verification Checklist

### Backend Verification
- [ ] `http://localhost:8000` returns a response
- [ ] Database has tables: users, cars, categories, etc.
- [ ] Database has 3 users (admin, moderator, user)
- [ ] Database has 5 categories with subcategories
- [ ] Storage link created: `Backend/public/storage` exists
- [ ] Logs are being written: `Backend/storage/logs/laravel.log`

### Frontend Verification
- [ ] `http://localhost:5173` loads the app
- [ ] Homepage shows car listings (or empty state)
- [ ] Navigation works (Home, Search, Favorites, etc.)
- [ ] Login modal appears when clicking "Sign In"
- [ ] No CORS errors in browser console
- [ ] Images load properly (if any cars exist)

### API Verification
- [ ] `GET http://localhost:8000/api/cars` returns car list
- [ ] `GET http://localhost:8000/api/categories` returns categories
- [ ] `POST http://localhost:8000/api/login` accepts credentials
- [ ] Protected routes require `Authorization` header
- [ ] Admin routes require admin role

---

## 🚨 Common Issues & Solutions

### Issue: "Database connection refused"
**Solution:**
- [ ] MySQL server is running
- [ ] Database credentials in `.env` are correct
- [ ] Database `insofauto` exists

### Issue: "CORS error in browser"
**Solution:**
- [ ] `FRONTEND_URL` in Backend `.env` matches frontend URL
- [ ] `SANCTUM_STATEFUL_DOMAINS` includes frontend domain
- [ ] Ran `php artisan config:clear`

### Issue: "Timer not expiring"
**Solution:**
- [ ] Scheduler is running: `php artisan schedule:work`
- [ ] Or manually run: `php artisan cars:expire-timers`

### Issue: "Images not uploading"
**Solution:**
- [ ] Ran `php artisan storage:link`
- [ ] `Backend/storage/app/public/cars` directory exists
- [ ] Web server has write permissions

### Issue: "401 Unauthorized on API calls"
**Solution:**
- [ ] Token is stored in localStorage
- [ ] Token is included in `Authorization: Bearer {token}` header
- [ ] User is not blocked
- [ ] Token hasn't expired

---

## 🎯 Final Checks

### Functionality Checklist
- [ ] User can register new account
- [ ] User can login
- [ ] User can browse cars
- [ ] User can search/filter cars
- [ ] User can view car details
- [ ] User can add cars to favorites
- [ ] User can create car listing
- [ ] Admin can login to admin panel
- [ ] Admin can view dashboard stats
- [ ] Admin can approve/reject cars
- [ ] Admin can manage users
- [ ] Admin can manage categories
- [ ] Timer system works (price hidden/revealed)
- [ ] Notifications are created
- [ ] Hot deals feature works

### Security Checklist
- [ ] Passwords are hashed (not plain text in DB)
- [ ] Admin panel requires authentication
- [ ] Regular users cannot access admin routes
- [ ] Blocked users cannot login
- [ ] File uploads are validated
- [ ] SQL injection prevention (using Eloquent)
- [ ] XSS protection enabled

### Performance Checklist
- [ ] Car listings are paginated
- [ ] Images are optimized (reasonable size)
- [ ] Database queries use indexes
- [ ] API responses are fast (< 1 second)

---

## 📝 Optional Configuration

### Email Notifications
- [ ] Configured mail settings in `.env`:
  ```
  MAIL_MAILER=smtp
  MAIL_HOST=smtp.gmail.com
  MAIL_PORT=587
  MAIL_USERNAME=your_email
  MAIL_PASSWORD=your_app_password
  ```

### Production Setup
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Ran `php artisan config:cache`
- [ ] Ran `php artisan route:cache`
- [ ] Ran `php artisan view:cache`
- [ ] Configured web server (Nginx/Apache)
- [ ] Setup cron job for scheduler
- [ ] SSL certificate configured (HTTPS)

---

## ✅ Installation Complete!

If all items are checked, your InsofAuto system is ready to use!

### What's Next?

1. **Customize Categories**
   - Edit `Backend/database/seeders/CategorySeeder.php`
   - Run `php artisan db:seed --class=CategorySeeder`

2. **Add Sample Cars**
   - Login as user
   - Create multiple car listings
   - Login as admin to approve them

3. **Test Timer System**
   - Approve a car
   - Watch timer countdown
   - Wait for expiration or manually trigger

4. **Customize Frontend**
   - Update colors in `Frond/tailwind.config.ts`
   - Modify components in `Frond/src/components`
   - Add new features

5. **Deploy to Production**
   - Follow deployment guide in DOCUMENTATION.md
   - Setup domain and SSL
   - Configure environment variables

---

## 📞 Need Help?

If any step fails:
1. Check error messages carefully
2. Review Laravel logs: `Backend/storage/logs/laravel.log`
3. Check browser console for frontend errors
4. Refer to DOCUMENTATION.md
5. Refer to QUICK_START.md

---

**Happy building! 🚗💨**

---

## Installation Commands Summary

### Backend
```bash
cd Backend
composer install
copy .env.example .env
php artisan key:generate
# Edit .env with database credentials
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve
# New terminal
php artisan schedule:work
```

### Frontend
```bash
cd Frond
npm install
npm install axios
# Create .env file
npm run dev
```

### Test Credentials
- Admin: admin@insofauto.com / admin123
- User: user@insofauto.com / user123
- Moderator: moderator@insofauto.com / moderator123

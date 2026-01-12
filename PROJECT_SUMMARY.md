# InsofAuto - Full-Stack Car Marketplace 🚗

## Project Overview

**InsofAuto** is a complete car marketplace system built with Laravel (Backend API) and React (Frontend). The platform features a unique **24-hour countdown timer** system where car prices are hidden initially and revealed after the timer expires.

---

## 🎯 System Architecture

```
┌─────────────────────────────────────────────┐
│          React Frontend (Vite)              │
│  - Mobile-first responsive UI               │
│  - Car browsing & search                    │
│  - User authentication                      │
│  - Favorites & notifications                │
│  - Admin dashboard access                   │
└─────────────────┬───────────────────────────┘
                  │
           HTTP/REST API
           Laravel Sanctum Auth
                  │
┌─────────────────▼───────────────────────────┐
│         Laravel Backend (API)               │
│  - RESTful API endpoints                    │
│  - Authentication & authorization           │
│  - Timer management system                  │
│  - Image upload handling                    │
│  - Role-based access control                │
└─────────────────┬───────────────────────────┘
                  │
┌─────────────────▼───────────────────────────┐
│            MySQL Database                   │
│  - Users, Cars, Categories                  │
│  - Favorites, Notifications                 │
│  - Complaints, Settings                     │
└─────────────────────────────────────────────┘
```

---

## ✨ Key Features

### 🔐 Authentication & Authorization
- **Laravel Sanctum** token-based authentication
- **Role-based access control**: Admin, Moderator, User
- Secure password hashing (Bcrypt)
- JWT-like token system for API access
- Separate admin login endpoint

### 🚗 Car Listing System
- **Create, Read, Update, Delete** car listings
- **Image upload** support (up to 10 images per car)
- **Categories & Subcategories** organization
- **Advanced filtering**: price, year, category, brand
- **Full-text search** across multiple fields
- **Pagination** for large datasets

### ⏱️ 24-Hour Timer System (Core Feature)
- When admin **approves** a car listing, timer starts automatically
- **Price is HIDDEN** during the 24-hour period
- Users can see all car details EXCEPT the price
- **Countdown timer** displayed to users
- After 24 hours:
  - Cron job automatically expires the timer
  - **Price becomes VISIBLE** to all users
  - **Notification sent** to car owner
- Admin can **manually control** timers:
  - Start timer with custom duration
  - Expire timer manually
  - Reset timer

### 🔥 Hot Deals
- Admin can mark cars as "Hot Deals"
- Featured section for hot deals
- Increased visibility for special offers

### ❤️ Favorites System
- Users can save favorite cars
- Dedicated favorites page
- Quick access to saved listings
- One-click add/remove

### 📱 Notifications
- Real-time notification system
- Notification types:
  - Car approved
  - Car rejected
  - Timer expired
  - Complaint resolved/rejected
- Unread count indicator
- Mark as read functionality

### 🚨 Complaint Management
- Users can report suspicious listings
- Admin review and response system
- Status tracking (pending, resolved, rejected)
- Admin response messages

### 👨‍💼 Admin Panel
- **Dashboard** with statistics:
  - Total cars, users, complaints
  - Pending approvals
  - Active/expired timers
  - Hot deals count
- **Car Management**:
  - Approve/reject pending listings
  - Edit car details
  - Delete listings
  - Toggle hot deal status
  - Manual timer control
- **User Management**:
  - View all users
  - Block/unblock users
  - Change user roles
  - View user's listings
- **Category Management**:
  - Create/edit/delete categories
  - Manage subcategories
  - Reorder categories
- **Complaint Handling**:
  - Review complaints
  - Respond to users
  - Resolve or reject complaints
- **System Settings**:
  - Configure timer duration
  - Adjust system parameters

### 🔒 Security Features
- **Password hashing** with Bcrypt
- **Token-based authentication**
- **Role-based middleware** protection
- **Input validation** on all requests
- **CSRF protection**
- **SQL injection prevention** (Eloquent ORM)
- **XSS protection**
- **Blocked user detection**
- **CORS configuration**

---

## 📁 Project Structure

```
insofauto/
├── Backend/                       # Laravel API
│   ├── app/
│   │   ├── Console/Commands/
│   │   │   └── ExpireCarTimers.php     # Cron job for timer expiration
│   │   ├── Http/
│   │   │   ├── Controllers/Api/        # Public API controllers
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── CarController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── FavoriteController.php
│   │   │   │   ├── ComplaintController.php
│   │   │   │   └── NotificationController.php
│   │   │   ├── Controllers/Api/Admin/  # Admin controllers
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── AdminCarController.php
│   │   │   │   ├── AdminUserController.php
│   │   │   │   ├── AdminCategoryController.php
│   │   │   │   ├── AdminComplaintController.php
│   │   │   │   └── AdminSettingController.php
│   │   │   └── Middleware/
│   │   │       ├── CheckRole.php       # Role-based access control
│   │   │       └── CheckBlocked.php    # Blocked user check
│   │   └── Models/
│   │       ├── User.php
│   │       ├── Car.php
│   │       ├── Category.php
│   │       ├── Subcategory.php
│   │       ├── CarImage.php
│   │       ├── Favorite.php
│   │       ├── Complaint.php
│   │       ├── Notification.php
│   │       └── Setting.php
│   ├── database/
│   │   ├── migrations/                 # Database schema
│   │   └── seeders/                    # Sample data
│   ├── routes/
│   │   └── api.php                     # API routes
│   └── config/
│       ├── cors.php                    # CORS configuration
│       └── sanctum.php                 # Authentication config
│
├── Frond/                             # React Frontend
│   ├── src/
│   │   ├── components/                # UI components
│   │   ├── pages/                     # Page components
│   │   ├── contexts/
│   │   │   └── AuthContext.tsx        # Authentication context
│   │   ├── services/                  # API service layer
│   │   │   ├── authService.ts
│   │   │   ├── carService.ts
│   │   │   ├── categoryService.ts
│   │   │   ├── favoriteService.ts
│   │   │   ├── notificationService.ts
│   │   │   └── adminService.ts
│   │   ├── lib/
│   │   │   └── api.ts                 # Axios instance
│   │   └── types/
│   │       └── car.ts                 # TypeScript types
│   └── package.json
│
├── DOCUMENTATION.md                   # Full documentation
├── QUICK_START.md                     # Quick start guide
└── PROJECT_SUMMARY.md                 # This file
```

---

## 🗄️ Database Schema

### Users
- Authentication & profile data
- Role: admin, moderator, user
- Block status

### Cars
- Full car details (brand, model, year, price, etc.)
- Timer fields (posted_at, timer_end_at, timer_expired)
- Price visibility flag
- Status (pending, approved, rejected, sold)
- Hot deal & featured flags

### Categories & Subcategories
- Hierarchical car categorization
- Active/inactive status
- Custom ordering

### Car Images
- Multiple images per car
- Primary image designation
- Image ordering

### Favorites
- User-car relationship
- Quick access to saved cars

### Complaints
- User complaints about listings
- Admin response & resolution
- Status tracking

### Notifications
- User notifications
- Read/unread tracking
- Notification types & data

### Settings
- System configuration
- Timer duration
- Registration rules

---

## 🔄 Core Workflows

### 1. Car Listing Creation Flow
```
User creates listing
    ↓
Status: PENDING
    ↓
Admin reviews
    ↓
┌─────────┴─────────┐
│                   │
APPROVE          REJECT
│                   │
↓                   ↓
Timer starts     Notify user
(24 hours)       Listing rejected
Price HIDDEN
    ↓
After 24h
Cron job runs
    ↓
Timer expires
Price VISIBLE
Notify user
```

### 2. Authentication Flow
```
User/Admin
    ↓
Submit credentials
    ↓
Backend validates
    ↓
Generate Sanctum token
    ↓
Return token + user data
    ↓
Frontend stores token
    ↓
Include in API requests
(Authorization: Bearer {token})
```

### 3. Timer Expiration Flow
```
Cron runs every minute
    ↓
Check cars where:
- timer_expired = false
- timer_end_at <= now()
    ↓
For each car:
- Set timer_expired = true
- Set price_visible = true
- Create notification
    ↓
User receives notification
Price now visible
```

---

## 🛠️ Technology Stack

### Backend
- **Framework**: Laravel 10
- **Authentication**: Laravel Sanctum
- **Database**: MySQL 5.7+
- **PHP**: 8.1+
- **ORM**: Eloquent
- **Task Scheduling**: Laravel Scheduler
- **Validation**: Laravel Request Validation

### Frontend
- **Framework**: React 18
- **Build Tool**: Vite
- **Language**: TypeScript
- **HTTP Client**: Axios
- **UI Components**: shadcn/ui
- **Styling**: Tailwind CSS
- **Routing**: React Router
- **State Management**: Context API
- **Notifications**: Sonner

### DevOps
- **Version Control**: Git
- **Dependency Management**: Composer (PHP), npm (Node.js)
- **Task Scheduling**: Cron (Linux) / Task Scheduler (Windows)

---

## 📊 API Endpoints Summary

### Public Routes
- `POST /api/register` - User registration
- `POST /api/login` - User login
- `GET /api/cars` - List cars (with filters)
- `GET /api/cars/{id}` - Get car details
- `GET /api/cars/hot-deals` - Hot deals
- `GET /api/categories` - List categories

### Protected User Routes (Requires Auth)
- `POST /api/logout` - Logout
- `GET /api/me` - Get current user
- `POST /api/cars` - Create car listing
- `PUT /api/cars/{id}` - Update car
- `DELETE /api/cars/{id}` - Delete car
- `GET /api/my-cars` - User's listings
- `GET /api/favorites` - Get favorites
- `POST /api/favorites` - Add favorite
- `DELETE /api/favorites/{id}` - Remove favorite
- `GET /api/notifications` - Get notifications
- `POST /api/complaints` - Submit complaint

### Admin Routes (Requires Admin/Moderator Role)
- `GET /api/admin/dashboard` - Dashboard stats
- `GET /api/admin/cars/pending` - Pending approvals
- `POST /api/admin/cars/{id}/approve` - Approve car
- `POST /api/admin/cars/{id}/reject` - Reject car
- `POST /api/admin/cars/{id}/toggle-hot-deal` - Toggle hot deal
- `POST /api/admin/cars/{id}/start-timer` - Start timer
- `POST /api/admin/cars/{id}/expire-timer` - Expire timer
- `GET /api/admin/users` - List users
- `POST /api/admin/users/{id}/block` - Block user
- `POST /api/admin/users/{id}/unblock` - Unblock user
- `GET /api/admin/complaints` - List complaints
- `POST /api/admin/complaints/{id}/resolve` - Resolve complaint
- `GET /api/admin/settings` - Get settings
- `PUT /api/admin/settings` - Update settings

---

## 🚀 Getting Started

### Quick Setup (5 Minutes)

**1. Backend Setup:**
```bash
cd Backend
composer install
copy .env.example .env
php artisan key:generate
# Configure database in .env
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve
```

**2. Start Scheduler (New Terminal):**
```bash
cd Backend
php artisan schedule:work
```

**3. Frontend Setup:**
```bash
cd Frond
npm install
# Create .env with: VITE_API_URL=http://localhost:8000/api
npm run dev
```

**4. Test Login:**
```
Admin: admin@insofauto.com / admin123
User: user@insofauto.com / user123
```

---

## 🎓 Learning Points

This project demonstrates:

1. **RESTful API Design** - Proper endpoint structure and HTTP methods
2. **Authentication & Authorization** - Token-based auth with role management
3. **Cron Jobs** - Scheduled tasks for automated processes
4. **File Uploads** - Image handling and storage
5. **Pagination** - Efficient data loading
6. **Filtering & Search** - Complex query building
7. **Notifications** - User engagement system
8. **Admin Workflows** - Approval processes and moderation
9. **Frontend-Backend Integration** - API consumption in React
10. **TypeScript** - Type-safe frontend development
11. **State Management** - Context API usage
12. **Responsive Design** - Mobile-first approach

---

## 📝 Default Test Data

After running seeders, you'll have:
- 3 user accounts (admin, moderator, user)
- 5 categories with subcategories
- System settings configured
- Timer duration set to 24 hours

---

## 🔮 Future Enhancements

Potential features to add:
- Real-time chat between buyer/seller
- Payment integration
- Car comparison feature
- Email notifications
- SMS notifications
- Advanced analytics dashboard
- Car loan calculator
- Insurance integration
- Multi-language support
- Dark mode
- Mobile app (React Native)

---

## 📄 License

This project is built for educational and commercial purposes.

---

## 👨‍💻 Development Notes

### Important Files to Know:
- `Backend/routes/api.php` - All API routes
- `Backend/app/Console/Kernel.php` - Cron schedule
- `Backend/app/Console/Commands/ExpireCarTimers.php` - Timer logic
- `Backend/app/Models/Car.php` - Car model with timer methods
- `Frond/src/services/` - All API service functions
- `Frond/src/contexts/AuthContext.tsx` - Authentication state

### Environment Variables:
**Backend (.env):**
- `DB_*` - Database configuration
- `CAR_TIMER_DURATION` - Timer hours (default: 24)
- `FRONTEND_URL` - React app URL for CORS
- `SANCTUM_STATEFUL_DOMAINS` - Domains for cookies

**Frontend (.env):**
- `VITE_API_URL` - Laravel API endpoint
- `VITE_APP_NAME` - Application name

---

## 🎉 Conclusion

**InsofAuto** is a production-ready car marketplace with unique timer-based pricing reveal system. The architecture is scalable, secure, and follows best practices for both Laravel and React development.

**Key Achievements:**
✅ Complete REST API with 50+ endpoints
✅ Secure authentication with role-based access
✅ Automated timer system with cron jobs
✅ Admin panel with full CRUD operations
✅ Mobile-responsive React frontend
✅ Real-time notifications
✅ Image upload & management
✅ Advanced filtering & search
✅ Comprehensive documentation

---

**Built with ❤️ for car enthusiasts and developers**

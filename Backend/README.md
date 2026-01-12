# InsofAuto Backend

Laravel-based REST API for car marketplace system.

## Setup

1. Install dependencies:
```bash
composer install
```

2. Configure environment:
```bash
copy .env.example .env
php artisan key:generate
```

3. Setup database:
```bash
# Edit .env with your database credentials
php artisan migrate
php artisan db:seed
php artisan storage:link
```

4. Run development server:
```bash
php artisan serve
php artisan schedule:work
```

## Default Credentials

**Admin:**
- Email: admin@insofauto.com
- Password: admin123

**Moderator:**
- Email: moderator@insofauto.com
- Password: moderator123

**User:**
- Email: user@insofauto.com
- Password: user123

## API Documentation

See main [DOCUMENTATION.md](../DOCUMENTATION.md) for complete API reference.

## Key Features

- Laravel Sanctum authentication
- Role-based access control
- 24-hour timer system for car listings
- Image upload handling
- Automatic price reveal after timer
- Admin approval workflow
- Notifications system
- CORS configured for frontend

## Important Commands

```bash
# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Clear cache
php artisan config:clear
php artisan cache:clear

# Check timer expiration (manual)
php artisan cars:expire-timers

# Start scheduler (required for timers)
php artisan schedule:work
```

## Production Deployment

1. Set environment:
```bash
APP_ENV=production
APP_DEBUG=false
```

2. Optimize:
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Setup cron job:
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

## Directory Structure

```
Backend/
├── app/
│   ├── Console/Commands/     # Custom artisan commands
│   ├── Http/
│   │   ├── Controllers/Api/  # API controllers
│   │   └── Middleware/       # Custom middleware
│   └── Models/               # Eloquent models
├── config/                   # Configuration files
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
└── routes/
    └── api.php               # API routes
```

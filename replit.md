# Project Farm Catalog

## Overview
A Laravel-based web application for cataloguing product testing results from the Project Farm YouTube channel. The site allows users to browse product categories from videos and sort/filter products based on test metrics measured in each category.

**Status**: Initial scaffolding complete (November 20, 2025)

## Technology Stack
- **Framework**: Laravel 12.x (latest)
- **Frontend Interactivity**: Livewire 3.6.x (public-facing)
- **Admin Panel**: Filament 4.2.x
- **Database**: SQLite (lightweight for Replit environment)
- **Styling**: Tailwind CSS 4.x
- **PHP Version**: 8.4

## Project Architecture

### Public-Facing Site (Livewire)
- **Route**: `/` - Home page
- **Layout**: `resources/views/layouts/app.blade.php`
- **Components**: 
  - `app/Livewire/Home.php` - Home page component
  - `resources/views/livewire/home.blade.php` - Home page view

### Admin Panel (Filament)
- **Route**: `/admin`
- **Provider**: `app/Providers/Filament/AdminPanelProvider.php`
- Admin panel is fully configured and ready for resource creation
- **Default Admin Credentials**:
  - Email: `admin@projectfarm.test`
  - Password: `password`
  - Created via: `database/seeders/AdminUserSeeder.php`

### Database
- Using SQLite for lightweight operation on Replit free tier
- Database file: `database/database.sqlite`
- Default migrations already run (users, cache, jobs tables)

## Replit Configuration
- **Server**: Runs on `0.0.0.0:5000` for Replit environment
- **Workflow**: "Laravel Server" - Auto-starts on project load
- **Build Steps**: None required (minimal JS, leverages Livewire for interactivity)
- **Assets**: Uses Tailwind CSS CDN for development (no build step needed)

## Setup Instructions

### First Time Setup
The application is pre-configured and ready to use. The admin user has already been seeded with these credentials:
- **Email**: `admin@projectfarm.test`
- **Password**: `password`

If you need to recreate the admin user, run:
```bash
php artisan db:seed --class=AdminUserSeeder
```

### Development vs Production
This setup is optimized for development on Replit's free tier:
- **Tailwind CSS CDN**: Used for zero-build development. For production, replace with compiled assets.
- **SQLite Database**: Lightweight and file-based. Already configured.
- **Migrations**: Already run and ready to use.

## Recent Changes
- **2025-11-20**: Initial project setup
  - Installed Laravel 12.39.0
  - Installed Livewire 3.6.4 for public interactivity
  - Installed Filament 4.2.2 for admin panel
  - Created basic application structure
  - Configured for Replit environment (port 5000)
  - Set up workflow for Laravel development server
  - Seeded admin user for Filament access
  - Configured CDN assets for zero-build development

## Next Steps
1. Define database schema for categories and products
2. Create migrations for category and product tables
3. Build Filament resources for admin data management
4. Create Livewire components for category browsing and product filtering
5. Add test metrics and filtering capabilities

## User Preferences
- Keep JavaScript usage minimal
- Rely on Livewire for all public-facing interactivity
- Use Filament exclusively for admin panel
- Maintain lightweight build process for Replit free tier

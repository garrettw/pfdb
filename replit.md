# Project Farm Catalog

## Overview
A Laravel-based web application for cataloguing product testing results from the Project Farm YouTube channel. The site allows users to browse product categories from videos and sort/filter products based on test metrics measured in each category. Uses a hybrid EAV (Entity-Attribute-Value) database design for flexible, category-specific test metrics.

**Status**: MVP Complete - Full CRUD admin panel and public browsing interface (November 20, 2025)

## Technology Stack
- **Framework**: Laravel 12.x (latest)
- **Frontend Interactivity**: Livewire 3.6.x (public-facing)
- **Admin Panel**: Filament 4.2.x
- **Database**: SQLite (lightweight for Replit environment)
- **Styling**: Tailwind CSS 4.x
- **PHP Version**: 8.4

## Project Architecture

### Public-Facing Site (Livewire)
- **Route**: `/` - Home page with category browser
- **Route**: `/category/{slug}` - Category detail page with product comparison table
- **Layout**: `resources/views/layouts/app.blade.php`
- **Components**: 
  - `app/Livewire/Home.php` - Category browser component
  - `app/Livewire/CategoryView.php` - Product comparison table with sorting/filtering
- **Features**:
  - Browse categories with product counts
  - Filter products by name/brand/model (real-time search)
  - Sort products by any test metric (database-level sorting)
  - View YouTube source videos for each category

### Admin Panel (Filament)
- **Route**: `/admin`
- **Provider**: `app/Providers/Filament/AdminPanelProvider.php`
- **Resources**:
  - **CategoryResource** - Manage categories with repeater for YouTube URLs
  - **AttributeResource** - Manage test metrics (scoped by category, type selection, units)
  - **ProductResource** - Add products with dynamic attribute fields based on selected category
- **Default Admin Credentials**:
  - Email: `admin@projectfarm.test`
  - Password: `password`
  - Created via: `database/seeders/AdminUserSeeder.php`
- **Features**:
  - Automatic slug generation from category names
  - Category-specific attribute management
  - Dynamic product forms that adapt to category attributes
  - Support for numeric and text attribute types

### Database
- Using SQLite for lightweight operation on Replit free tier
- Database file: `database/database.sqlite`
- **Schema** (Hybrid EAV Model):
  - `categories` - Product categories with metadata (video URLs as JSON)
  - `attributes` - Test metrics/attributes scoped by category
  - `products` - Products with basic info (name, brand, model, notes)
  - `product_attributes` - EAV pivot table storing attribute values
- **Migrations**:
  - `2025_11_20_061750_create_categories_table.php`
  - `2025_11_20_061750_create_products_table.php`
  - `2025_11_20_061751_create_attributes_table.php`
  - `2025_11_20_061752_create_product_attributes_table.php`
- **Seeders**:
  - `AdminUserSeeder` - Creates admin account
  - `CategorySeeder` - Sample categories (Penetrating Oils, AA Batteries, Chainsaws)
  - `AttributeSeeder` - Sample test metrics for each category
  - `ProductSeeder` - Sample products with test data

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
- **2025-11-20**: MVP Implementation Complete
  - Installed Laravel 12.39.0 with Livewire 3.6.4 and Filament 4.2.2
  - Implemented hybrid EAV database schema for flexible category-specific attributes
  - Created Eloquent models with relationships (Category, Product, Attribute, ProductAttribute)
  - Built Filament admin resources with dynamic forms:
    - CategoryResource with video URL repeater field
    - AttributeResource with type selection (numeric/text)
    - ProductResource with category-scoped dynamic attribute fields
  - Developed public Livewire components:
    - Home component for category browsing
    - CategoryView component with efficient database-level sorting and filtering
  - Optimized query performance:
    - Eager loading to eliminate N+1 queries
    - Database-level sorting via LEFT JOIN for scalability
    - Custom `getEavAttribute()` and `setEavAttribute()` methods (avoiding Laravel naming conflicts)
  - Seeded sample data for testing
  - Configured for Replit environment (port 5000, zero-build with Tailwind CDN)

## Next Steps
1. Populate database with real Project Farm testing data
2. Add pagination to category views for large product lists
3. Consider adding image uploads for products
4. Add data export features (CSV/PDF)
5. For production: replace Tailwind CDN with compiled assets

## User Preferences
- Keep JavaScript usage minimal
- Rely on Livewire for all public-facing interactivity
- Use Filament exclusively for admin panel
- Maintain lightweight build process for Replit free tier

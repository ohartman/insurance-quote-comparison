# Insurance Quote Comparison Dashboard

A modern full-stack application for comparing insurance quotes across multiple providers. Built with Laravel 12, Vue 3, and TypeScript.

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Vue 3, TypeScript, Vite
- **Database:** MySQL
- **Styling:** Tailwind CSS
- **State Management:** Pinia
- **Containerization:** Docker

## Features

- 📊 Compare insurance quotes side-by-side
- 🔍 Filter by coverage type and price range
- 💾 RESTful API with Laravel
- ✅ Form validation (client & server)
- 🎨 Responsive design with Tailwind
- 🧪 Unit tested backend
- 🔒 API authentication ready

## About This Project

**Note:** This is a **demonstration/portfolio project** showcasing full-stack development skills with Laravel 12, Vue 3, and TypeScript. It contains the complete application logic (models, controllers, Vue components, tests) but requires integration into a full Laravel 12 application to run.

### What's Included

✅ **Complete Application Logic**
- Laravel models with relationships
- RESTful API controllers with resources
- Database migrations and seeders with sample data
- Vue 3 components with TypeScript
- Pinia state management
- PHPUnit feature tests
- Tailwind CSS styling

✅ **Skills Demonstrated**
- Full-stack CRUD operations
- API design with validation
- Database relationships
- Vue 3 Composition API
- TypeScript interfaces
- Responsive UI design
- Testing practices

### To Review This Code

Simply browse the repository structure:
- `app/Models/` - Quote and Provider models with relationships
- `app/Http/Controllers/Api/` - RESTful API endpoints
- `app/Http/Resources/` - Consistent JSON responses
- `database/migrations/` - Database schema design
- `resources/js/components/` - Vue 3 + TypeScript components
- `resources/js/stores/` - Pinia state management
- `tests/Feature/` - PHPUnit tests

### To Run This Project

This would need to be integrated into a fresh Laravel 12 installation:

```bash
# Start with fresh Laravel 12
composer create-project laravel/laravel insurance-app
cd insurance-app

# Copy in the demonstration files from this repo
# Install frontend dependencies
npm install

# Run standard Laravel setup
php artisan migrate --seed
php artisan serve
npm run dev
```

## Project Structure

```
├── app/
│   ├── Http/Controllers/Api/
│   │   └── QuoteController.php
│   └── Models/
│       ├── Quote.php
│       └── Provider.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── js/
│   │   ├── components/
│   │   │   ├── QuoteCard.vue
│   │   │   ├── QuoteComparison.vue
│   │   │   └── QuoteForm.vue
│   │   ├── stores/
│   │   │   └── quoteStore.ts
│   │   └── app.ts
│   └── views/
├── routes/
│   └── api.php
└── tests/
    └── Feature/
        └── QuoteApiTest.php
```

## API Endpoints

```
GET    /api/quotes           - List all quotes
POST   /api/quotes           - Create new quote
GET    /api/quotes/{id}      - Get single quote
PUT    /api/quotes/{id}      - Update quote
DELETE /api/quotes/{id}      - Delete quote
GET    /api/providers        - List providers
```

## Testing

```bash
# Run backend tests
php artisan test

# Run with coverage
php artisan test --coverage
```

## Development Notes

- Uses Vue 3 Composition API with TypeScript
- Pinia for centralized state management
- Laravel API Resources for consistent responses
- Form validation on both client and server
- Responsive design mobile-first approach

## Built By

Owen Hartman - [GitHub](https://github.com/ohartman) | [LinkedIn](https://linkedin.com/in/rowen-hartman)

**View this project:** https://github.com/ohartman/insurance-quote-comparison

Built as a demonstration of modern full-stack development with Laravel and Vue.

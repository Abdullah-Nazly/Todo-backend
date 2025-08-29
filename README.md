# Todo Backend (Laravel)

This is the backend API for the Todo project built with Laravel 12 and PHP 8.2+.

## Prerequisites

Before you begin, ensure you have the following installed on your system:

### Required Software

- **PHP** (version 8.2 or higher)
  - Download from [php.net](https://php.net/downloads.php)
  - Required extensions: `bcmath`, `ctype`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`
  - Verify installation: `php --version`

- **Composer** (latest version)
  - Download from [getcomposer.org](https://getcomposer.org/download/)
  - Verify installation: `composer --version`

- **Database** (choose one):
  - **MySQL** (8.0+) - [Download](https://dev.mysql.com/downloads/)
  - **PostgreSQL** (13+) - [Download](https://www.postgresql.org/download/)
  - **SQLite** (3.35+) - Usually comes with PHP

- **Web Server** (choose one):
  - **Laravel Sail** (Docker-based) - Recommended for development
  - **PHP Built-in Server** - For quick testing
  - **Apache/Nginx** - For production

### Optional but Recommended

- **Node.js** (for Vite asset compilation)
- **Redis** (for caching and sessions)
- **Docker** (if using Laravel Sail)

## Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/Abdullah-Nazly/Todo-backend.git
cd Todo-backend
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

Copy the environment file and configure it:

```bash
cp .env.example .env
```

**If `.env.example` doesn't exist, create `.env` with these basic settings:**

```env
APP_NAME="Todo Backend"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_db
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

JWT_SECRET=
JWT_TTL=60
JWT_REFRESH_TTL=20160
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Generate JWT Secret

```bash
php artisan jwt:secret
```

### 6. Database Setup

#### Option A: Using Laravel Sail (Docker)

```bash
# Start the Docker containers
./vendor/bin/sail up -d

# Run migrations
./vendor/bin/sail artisan migrate

# Seed the database (optional)
./vendor/bin/sail artisan db:seed
```

#### Option B: Local Database

1. **Create Database:**
   ```sql
   CREATE DATABASE todo_db;
   ```

2. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

3. **Seed Database (optional):**
   ```bash
   php artisan db:seed
   ```

### 7. Start Development Server

#### Option A: Laravel Sail
```bash
./vendor/bin/sail up
```

#### Option B: PHP Built-in Server
```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

## API Endpoints

### Authentication
- `POST /api/auth/login` - User login
- `POST /api/auth/register` - User registration
- `POST /api/auth/logout` - User logout
- `POST /api/auth/refresh` - Refresh JWT token

### Todos
- `GET /api/todos` - Get all todos (authenticated)
- `POST /api/todos` - Create new todo (authenticated)
- `GET /api/todos/{id}` - Get specific todo (authenticated)
- `PUT /api/todos/{id}` - Update todo (authenticated)
- `DELETE /api/todos/{id}` - Delete todo (authenticated)

## Development Commands

### Artisan Commands

```bash
# Clear various caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# List all routes
php artisan route:list

# Create a new controller
php artisan make:controller ControllerName

# Create a new model
php artisan make:model ModelName

# Create a new migration
php artisan make:migration create_table_name

# Create a new seeder
php artisan make:seeder SeederName
```

### Testing

```bash
# Run tests
php artisan test

# Run tests with coverage
php artisan test --coverage

# Run specific test file
php artisan test tests/Feature/ExampleTest.php
```

### Database

```bash
# Rollback migrations
php artisan migrate:rollback

# Reset and re-run migrations
php artisan migrate:refresh

# Drop all tables and re-run migrations
php artisan migrate:fresh

# Seed database
php artisan db:seed
```

## Project Structure

```
app/
├── Http/
│   ├── Controllers/     # API controllers
│   │   ├── AuthController.php
│   │   ├── TodoController.php
│   │   └── Controller.php
│   └── Middleware/      # Custom middleware
│       └── CORS.php
├── Models/              # Eloquent models
│   ├── Todo.php
│   └── User.php
└── Providers/           # Service providers
    └── AppServiceProvider.php

config/                  # Configuration files
├── auth.php            # Authentication config
├── database.php        # Database config
├── jwt.php            # JWT config
└── cors.php           # CORS config

database/
├── migrations/         # Database migrations
├── seeders/           # Database seeders
└── factories/         # Model factories

routes/
└── api.php            # API routes

tests/                  # Test files
├── Feature/           # Feature tests
└── Unit/              # Unit tests
```

## Configuration

### Database Configuration

Update your `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### JWT Configuration

JWT settings are in `config/jwt.php`. Key settings:

```php
'ttl' => env('JWT_TTL', 60), // Token lifetime in minutes
'refresh_ttl' => env('JWT_REFRESH_TTL', 20160), // Refresh token lifetime
'secret' => env('JWT_SECRET'), // JWT secret key
```

### CORS Configuration

CORS settings are in `config/cors.php`. Update allowed origins:

```php
'allowed_origins' => ['http://localhost:4200'], // Your frontend URL
```

## Troubleshooting

### Common Issues

1. **Composer memory limit**
   ```bash
   COMPOSER_MEMORY_LIMIT=-1 composer install
   ```

2. **Permission issues (Linux/Mac)**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

3. **Database connection errors**
   - Verify database credentials in `.env`
   - Ensure database server is running
   - Check if database exists

4. **JWT errors**
   ```bash
   php artisan jwt:secret
   php artisan config:clear
   ```

5. **Port already in use**
   ```bash
   php artisan serve --port=8001
   ```

### Performance Tips

- Use Redis for caching: `CACHE_DRIVER=redis`
- Enable route caching: `php artisan route:cache`
- Enable config caching: `php artisan config:cache`
- Use database indexing for frequently queried fields

## Production Deployment

### Environment Variables
- Set `APP_ENV=production`
- Set `APP_DEBUG=false`
- Use strong, unique `APP_KEY`
- Configure production database credentials
- Set up proper logging

### Security
- Use HTTPS in production
- Configure proper CORS origins
- Set secure session and cookie settings
- Use environment-specific JWT secrets

### Performance
- Enable OPcache
- Use Redis for sessions and caching
- Configure proper database connection pooling
- Use CDN for static assets

## Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)
- [JWT Auth Package](https://github.com/tymondesigns/jwt-auth)
- [Laravel Sail](https://laravel.com/docs/sail)

## Support

If you encounter any issues:
1. Check Laravel logs in `storage/logs/`
2. Verify all prerequisites are installed correctly
3. Ensure environment variables are properly set
4. Check the [Laravel GitHub issues](https://github.com/laravel/laravel/issues) for known problems

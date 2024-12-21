# Laravel Podcasts Project

## Description
A Laravel-based web application for managing and exploring podcasts, allowing users to discover, listen to, and interact with podcast content.

## Prerequisites
- Docker
- Docker Compose
- Composer
- PHP 8.3+

## Installation

### 1. Clone the Repository
```bash
git clone https://github.com/Gammarase/podcast-api.git
cd podcast-api
```

### 2. Environment Configuration
Copy the example environment file and configure your settings:
```bash
cp .env.example .env
```

Edit the `.env` file to set your database, mail, and other configuration details.

### 3. Start Docker Containers
```bash
docker-compose up -d
```

### 4. Install Dependencies
```bash
docker-compose exec app composer install
```

### 5. Generate Application Key
```bash
docker-compose exec app php artisan key:generate
```

### 6. Run Migrations and Seed Database
```bash
docker-compose exec app php artisan migrate --seed
```
### 7. Link storage to use saved files by url
```bash
docker-compose exec app php artisan storage:link

```
### 8. Generate docs and access them on /docs route
```bash
docker-compose exec app php artisan scribe:generate
```

## Features
- User authentication
- Podcast browsing
- Podcast saving
- Episode playback
- User ratings

## Project Structure
- `app/`: Application core logic
- `config/`: Configuration files
- `database/`: Migrations and seeders
- `resources/`: Views and frontend assets
- `routes/`: Application routing

## Testing
Run the test suite:
```bash
docker-compose exec app php artisan test
```

## License
This project is open-sourced under the MIT License.

Project Link: [https://github.com/yourusername/laravel-podcasts](https://github.com/yourusername/laravel-podcasts)

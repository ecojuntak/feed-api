## Prerequisite
- Install PHP 7.2
- Install MySQL Server
- Install RabbitMQ Server
- Install Composer

## Download Dependencies
```
composer install
```

## Configuration
- Copy the `.env.example` to new file, name it `.env`
- Set the database connection variables in the `.env` file
- Run the migration
```
php artisan migrate
```

## Run the Server
```
php -S localhost:8000 -t public
```

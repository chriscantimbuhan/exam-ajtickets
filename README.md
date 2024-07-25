# AJTickets PHP Practical Exam

## Requirements:
- SqLite
- PHP v8.3^
- Composer v2.*

## Installation

## BACKEND
Clone the project.

Navigate to the project folder via terminal.
```sh
cd project_folder
```

Create your SqLite database.
Create a file in database folder named "database.sqlite"

Install composer packages.
```sh
composer install
```
Copy or move env.sample to .env.
```sh
cp env.example .env
```

Migrate tables to database.
```sh
php artisan migrate
```

## USAGE
Create Burger Components First
```sh
php artisan burger:manage-component
```
Once burger components are available, You may start to create your burger
```sh
php artisan burger:burger:build
```

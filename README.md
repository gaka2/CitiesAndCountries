# Requirements:
```
PHP 7.4
MariaDB 10.4.17
```

# Installation

1. Run:
```
git clone <repository_url>
composer install
```

2. Run (CLI or via phpMyAdmin):
```
CREATE DATABASE geo_db;
CREATE USER 'geo_app'@'localhost' IDENTIFIED BY '8Qgn9dQp8fJjgfujykQELC';
GRANT ALL PRIVILEGES ON geo_db.* TO 'geo_app'@'localhost';
```

3. Run:
```
php bin/console doctrine:migrations:migrate
php bin/console cache:clear
```

# Usage

## Create country
Run:
```
php bin/console app:add-country <country_name>
```

## Create city
Run server (Symfony Local Web Server):
```
symfony server:start
```

Send POST request:
```
http://localhost:8000/api/cities/
{"name":"City name", "country":1}
```

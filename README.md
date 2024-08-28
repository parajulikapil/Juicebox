# Juicebox Development Environment

## Documentation
* Laravel: https://laravel.com/docs/11.x
* Postman: https://documenter.getpostman.com/view/1465881/2sAXjJ6Ytt

## Prerequisites
* Install PHP version 8.2
* Install composer
* Database MYSQL

# Steps to install project
```Shell
1) composer install
```
```Shell
2) Duplicate .env.example with .env file
```
## Take note of below while updating .env file
* `Step 1 ` Change Database configuration
* `Step 2 ` Change Mail configuration

```Shell
3) php artisan migrate
```

```Shell
4) php artisan serve --port=<YOUR_PREFERED_PORT> Eg: php artisan serve --port=8001
```

# How to do Unit Testing
```Shell
php artisan test
```
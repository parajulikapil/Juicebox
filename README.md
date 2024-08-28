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
* `Step 1 ` Change Database configuration as per your development setup
* `Step 2 ` Change Mail configuration as per your development setup

```Shell
3) php artisan migrate
```

```Shell
4) php artisan serve --port=<YOUR_PREFERED_PORT> Eg: php artisan serve --port=8001
```

## How to run Queue worker
```Shell
For development run: "php artisan queue:work"
For Deployment/production: Check https://laravel.com/docs/11.x/queues to install and configure supervisor
```
## How to run Manually email job
* Take note your queue is running.
* Run: "php artisan mail:send-welcome-email {userId}"
    * Example: "php artisan mail:send-welcome-email 1"
    * 1 means user id please make sure to create user and grab user id before using this command

## How to run Unit Testing
```Shell
php artisan test
```
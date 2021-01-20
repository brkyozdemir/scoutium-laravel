<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

# Assuming you have already installed php, you could follow the steps below;

- php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
- php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
- php composer-setup.php
- php -r "unlink('composer-setup.php');"

# Configuring Environment Variables
- create a db named 'laravel' and configure the environment variables

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=[db username]
DB_PASSWORD=[db password]

- configure your environment variables as your Mailgun credentials shown below

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org 
MAIL_PORT=587
MAIL_USERNAME=[your user name]
MAIL_PASSWORD=[your password]
MAIL_ENCRYPTION=tls
MAIL_FROM_NAME="${APP_NAME}"
MAILGUN_DOMAIN=[your domain name]

- as this is a test project, you cannot send any mails other your registered email in Mailgun. So, configure variable below with your email address

MAIL_TO_ADDRESS=[your email]

- as this uses redis, you have to change the variable below as it is 

QUEUE_CONNECTION=redis

# Then run the commands below;
- composer install
- php artisan migrate
- php artisan queue:work

- Now, you can use the collection I sent to proceed through steps as expected

## Register
- Register with any credential you want

{
    "name": "name",
    "email": "email@address.com", (required)
    "password": "password" (required)
}

## Login 
- You get the authentication token from response

{
    "email": "email@address.com",
    "password": "password"
}

## Send an invitation token
- You have to add an 'Authorization' header to be able to send this invitation

{
    "email": "yourfriend@address.com",
    "sender": "email@address.com" (I know this looks bizarre and is normally sent by frontend without entering in any input. You have to enter manually on postman because there is no frontend )
}

## Register with token
- You can check the wallet from the response

{
    "name": "name",
    "password": "password", (required)
    "token": "token" (required to make this request 'register with token' rather than only 'register')
}


# Configuring Environment Variables
- create a db named 'laravel' and configure the environment variables

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=[db username]
DB_PASSWORD=[db password]
```

- configure your environment variables as your Mailgun credentials shown below

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org 
MAIL_PORT=587
MAIL_USERNAME=[your user name]
MAIL_PASSWORD=[your password]
MAIL_ENCRYPTION=tls
MAIL_FROM_NAME="${APP_NAME}"
MAILGUN_DOMAIN=[your domain name]
```

- as this is a test project, you cannot send any mails other your registered email in Mailgun. So, configure variable below with your email address

```
MAIL_TO_ADDRESS=[your email]
```

- as this uses redis, you have to change the variable below as it is 

```
QUEUE_CONNECTION=redis
```

# Then run the commands below;
- `composer install`
- `php artisan migrate`
- `php artisan queue:work`

- Now, you can use the collection I sent to proceed through steps as expected

## Register
- Register with any credential you want
```
{
    "name": "name",
    "email": "email@address.com",
    "password": "password" 
}
```

email => (required)
password => (required)

## Login 
- You get the authentication token from response

```
{
    "email": "email@address.com",
    "password": "password"
}
```

email => (required)
password => (required)

## Send an invitation token
- You have to add an 'Authorization' header to be able to send this invitation

```
{
    "email": "yourfriend@address.com",
    "sender": "email@address.com" 
}
```
(I know this looks bizarre and is normally sent by frontend without entering in any input. You have to enter manually on postman because there is no frontend )

## Register with token
- You can check the wallet from the response

```
{
    "name": "name",
    "password": "password",
    "token": "token" 
}
```

password => (required)
token => (required to make this request 'register with token' rather than only 'register')

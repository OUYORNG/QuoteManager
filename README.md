# Quote Manager - Docker Setup

This project uses Docker to run a **Next.js frontend**, a **Laravel backend**, an **Nginx web server**, and a **MySQL database**.

## Prerequisites

Ensure you have the following installed:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Project Structure

📂 project-root/
├── 📂 QM_WEB/         # Next.js frontend
├── 📂 QM_Backend/     # Laravel backend
├── 📄 php.ini         # Custom PHP configuration
├── 📄 nginx.conf      # Nginx configuration
├── 📄 docker-compose.yml  # Docker Compose configuration
└── 📄 README.md       # Documentation

## Clone the Repository

git clone https://github.com/your-repo/quote-manager.git
cd quote-manager

## Create .env file in QM_WEB and QM_Backend

QM_WEB

NEXT_PUBLIC_API_TOKEN=your_login_token
NEXT_PUBLIC_API_URL=http://localhost:8003

QM_Backend
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:NmHrwwNo5+13zKtfW95DdgMk+n5+EFPuqmESy5hjNdI=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=mysql_db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=laravel

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

## Running project with docker

- Building docker container with this command
  docker-compose up --build -d

- Navigate to QM_Backend
  composer update or composer install

- Navigate to docker container Quote_Manger
  docker exec -it Quote_Manager bash

- Give permission to Laravel app
  chown -R www-data:www-data /var/www/storage
  chmod -R 775 /var/www/storage

- Go to Quote_Manager image in docker and migrate with seeding
    php artisan migrate:fresh --seed

## NOTE 
- Make sure you sign in and get the token to put in QM_WEB env
- Adjust your port on each services if conflicts

# Library API
A demo API application using Laravel that facilitates the Library management of Books. The system allow user to add multiple Bookshelves and Books with chapter and page content.

### Application Features:
- Laravel 12 + Breeze + Sanctum API


## Installation

New Laravel application? make sure that your local machine has `PHP`, `Composer`, `Node`, `NPM` and the `Laravel installer` installed.

Read Doc: [Installing PHP and the Laravel Installer](https://laravel.com/docs/12.x/installation#installing-php)

### Installing PHP and the Laravel Installer

macOS installer:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/mac/8.4)"
```

Windows installer by Windows PowerShell:

```sh
# Run as administrator...
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))
```

Linux installer:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.4)"
```


Already have PHP and Composer installed? then install the Laravel installer via Composer::

```sh
composer global require laravel/installer
```

### Installation Using Herd

I recommend to [Install Laravel Herd](https://herd.laravel.com/) for local development environment.

*Laravel Herd is considered the best for many due to its ability to simplify local development or test, providing a fast and convenient environment for building Laravel applications.*


## Clone Repository

Clone the repo locally:

```sh
git clone https://github.com/anikninja/Library-API.git
cd Library-API
```

Install PHP dependencies:

```sh
composer install
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Create an SQLite database. You can also use another database (MySQL, Postgres), simply update your configuration accordingly.

```sh
touch database/database.sqlite
```

Run database migrations:

```sh
php artisan migrate
```

Run database seeder:

```sh
php artisan db:seed
```

Run server:

```sh
php artisan serve
```

Test It is running or not? Click on following url [http://127.0.0.1:8000] in your Terminal.


## Running on Postman

To run the api follow the Postman Collection:

```
https://www.postman.com/arch-interactive/workspace/optimal-byte-ltd/collection/42130544-e6e2bf39-74e8-48d0-b23a-4e4d574a86bd?action=share&creator=42130544&active-environment=42130544-6f2ee8b8-416e-431c-bc61-c97a34019339
```


## Credits

🚀 Original work by Anik [@anikninja](https://www.github.com/anikninja)

[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/anik89bd/)

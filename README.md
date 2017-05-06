Snipp
-----

Snippet-sharing web application built with Phalcon PHP framework

Requirement
-----------

- PHP >= 7.1
- MySQL 5.5
- Phalcon >= 3.1.2 [https://phalconphp.com](https://phalconphp.com)
- Apache >= 2.4
- Composer [https://getcomposer.org](https://getcomposer.org)

Installation
------------

- Clone this repository
- Run `composer install`
- Setup your virtual host and point `DocumentRoot` to `public` directory of this application
- In application directory, create new directory `storages/logs` and `storages/caches`. Make sure both directories are writeable by web server, for example on Debian, run `chown www-data:www-data storages/logs`
- Copy `app/config/app.php.example` to `app/config/app.php`, edit configuration to match your system
- Run `./migrations/migrate.sh [your_db_username] [your_db_name]` to setup MYSQL table schema. Replace `[your_db_username]` and `[your_db_name]` with your username and database name. Enter your password when prompted.

Have fun.
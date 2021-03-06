Snipp
-----

Snippet-sharing web application built with Phalcon PHP framework.

Requirement
-----------

- PHP >= 5.5 [https://php.net](https://php.net)
- MySQL 5.5
- Phalcon >= 3.1.2 [https://phalconphp.com](https://phalconphp.com)
- Apache >= 2.4
- Composer [https://getcomposer.org](https://getcomposer.org)
- Sass >= 3 [http://sass-lang.com](http://sass-lang.com)

Installation
------------

- Clone this repository
- Run `composer install`
- Setup your virtual host and point `DocumentRoot` to `public` directory of this application
- If using Apache, copy `.htaccess.example` to `.htaccess` and make change as appropriate.
- Make sure all directories and files permission are correct. For example 755 will be suffice for directories and 644 will suffice for PHP scripts.
- In application directory, create new directory `storages/logs` and `storages/caches`. Make sure both directories are writeable by web server, for example on Debian, run `chown www-data:www-data storages/logs`
- Copy `app/config/app.php.example` to `app/config/app.php`, edit configuration to match your system.
- Make sure `migrations/migrate.sh` and `migrations/seeder.sh` file is executable. If not, make it executable by running `chmod +x migrations/migrate.sh`.
- Run `./migrations/migrate.sh [your_db_username] [your_db_name]` to setup MYSQL table schema. Replace `[your_db_username]` and `[your_db_name]` with your username and database name. Enter your password when prompted.
- Run `./migrations/seeder.sh [your_db_username] [your_db_name]` to seed default data.
- Make sure `resources/sassme.sh` file is executable. If not, make it executable.
- Run `./resources/sassme.sh [theme]` to compile scss file to css. Replace `[theme]` with `default` to compile default theme style located in `resources/styles/default/scss/style.scss` to `public/assets/default/css/style.css`.

Have fun.

Snipp
-----

Snippet-sharing web application built with Phalcon PHP framework

Requirement
-----------

- PHP >= 7.1
- Phalcon >= 3.1.2 [https://phalconphp.com](https://phalconphp.com)
- Apache >= 2.4
- Composer [https://getcomposer.org](https://getcomposer.org)

Installation
------------

- Clone this repository
- Run `composer install`
- Setup your virtual host and point `DocumentRoot` to `public` directory of this application
- Make sure `storages/logs` and `storages/caches` directory are writeable by web server, for example on Debian, run `chown www-data:www-data storages/logs`
- Copy `app/config/app.php.example` to `app/config/app.php`, edit configuration to match your system

Have fun.
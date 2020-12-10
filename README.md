# Airplane seats
[![Build Status](https://travis-ci.org/andrew-svirin/ebics-client-php.svg?branch=master)](https://travis-ci.org/andrew-svirin/ebics-client-php)
Task is described here https://gist.github.com/lucasssa/e580a19783d4babebdeffcd397adcd96

## Environment
1. Install Apache2.
1. Install PHP 7.4.
1. Install MySQL of last version.

## Setup project
1. Clone repository `git clone git@github.com:andrew-svirin/interview_20201209.git`
1. Install dependencies `composer install --no-dev`
1. Create database `interview_20201209` in MySQL.
1. Create a virtual host for Apache and point on file `public/index.php`.
1. Create `.env` file `composer run-script create-env-config`.
1. Setup db connection in `.env` file.
```
...
# Database connection
DB_NAME=interview_20201209
DB_HOST=localhost
DB_USERNAME=<mysql_username>
DB_PASSWORD=<mysql_passsword>
...
```

## Development
1. Install dependencies `composer install`
1. Create `phpunit.xml` file `composer run-script create-phpunit-config`.
1. Run tests `./vendor/bin/phpunit`
1. Run code analyzer `./vendor/bin/phpstan alayze`
1. Run code format checker `./vendor/bin/phpcs`
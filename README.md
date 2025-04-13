# CodeIgniter 4 Application Starter

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

## How to run this application

Before you review this application, make sure you prepare for the requirement.

# Information Architecture

- Beranda / Dashboard
  - Ringkasan Cashflow
  - Grafik Visualisasi (Bulan, Kategori, Unit)

- Cashflow
  - Lihat Semua Transaksi
  - Tambah Transaksi
  - Edit / Hapus Transaksi

- RAPB (Rencana Anggaran)
  - Lihat RAPB per Unit
  - Tambah RAPB
  - Edit / Hapus RAPB

- User Management (Admin)
  - Daftar User
  - Tambah / Edit User
  - Role & Unit Assignment

- Autentikasi
  - Login / Logout

# Requirement

> - PHP (get from laragon, xampp, or any web server platform you'd like)
> - Composer (get the latest version, or else you can't run this application)

# how to run this application ?

make it simple, open your terminal you can use visual studio code, etc. if you using command prompt, you need to direct the folder target with cd command (ex  "cd D:/[your folder]" ). 

Then run "composer install", wait until the vendor folder shows and wait until every package installment complete. After that, run local server by using php spark serve. and that's it, you're done. Thanks for reading this.

# .env.development

env is for global variable that will use for configuration in global based (setting database, application mode, etc). use this when you want to build with your own configuration by deleting the .development (from .env.development to .env).

## Custom Command

this project have a custom command that will use for clearing session, etc (soon i'll make another)

# 1. clear:session

This command will clearing out all session, it is best for use in development mode, production mode should use cron job

# 2. migrate:freseed

This command will rollback your migration, migrating all tables and put seed on a few tables (need to create a seeder and then run the seeder in DatabaseSeeder.php)

# 3. deploy

(This command is still under experiment) this command will help you to deploy your application into docker
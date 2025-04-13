<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Deploy extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'custom';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'deploy';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Deploy your application with docker';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = '';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        CLI::write('🔧 Membuat file Docker...', 'yellow');

        // Buat Dockerfile
        file_put_contents(ROOTPATH . 'Dockerfile', <<<DOCKER
        FROM php:8.1-apache

        RUN apt-get update && apt-get install -y \\
            libpng-dev \\
            libonig-dev \\
            libxml2-dev \\
            zip \\
            unzip \\
            git \\
            curl \\
            && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

        COPY . /var/www/html/
        WORKDIR /var/www/html/

        RUN chown -R www-data:www-data /var/www/html \\
            && a2enmod rewrite
        DOCKER);

                // Buat docker-compose.yml
                file_put_contents(ROOTPATH . 'docker-compose.yml', <<<YML
        version: '3.8'

        services:
        app:
            build:
            context: .
            dockerfile: Dockerfile
            ports:
            - "8080:80"
            volumes:
            - .:/var/www/html
            depends_on:
            - db
            environment:
            - CI_ENVIRONMENT=development

        db:
            image: mysql:8.0
            restart: always
            environment:
            MYSQL_DATABASE: ci4db
            MYSQL_USER: user
            MYSQL_PASSWORD: secret
            MYSQL_ROOT_PASSWORD: rootsecret
            ports:
            - "3306:3306"
            volumes:
            - db_data:/var/lib/mysql

        volumes:
        db_data:
        YML);

        CLI::write('✅ File Docker berhasil dibuat!', 'green');

        // Jalankan docker compose
        CLI::write('🚀 Menjalankan docker-compose up...', 'yellow');
        passthru('docker-compose up -d');

        CLI::write('✅ Deploy selesai! Akses aplikasi di http://localhost:8080', 'green');
    }
}

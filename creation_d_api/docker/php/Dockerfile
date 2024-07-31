FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    netcat-openbsd

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY wait-for-mysql.sh /var/www/

RUN chmod +x /var/www/wait-for-mysql.sh

ENTRYPOINT [ "/var/www/wait-for-mysql.sh", "db", "3306", "php-fpm" ]

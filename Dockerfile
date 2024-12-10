FROM php:8.2-cli

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    wget \
    build-essential \
    pkg-config \
    && docker-php-ext-install zip

# Instalar SQLite manualmente
RUN wget https://www.sqlite.org/2023/sqlite-autoconf-3410000.tar.gz \
    && tar -xvf sqlite-autoconf-3410000.tar.gz \
    && cd sqlite-autoconf-3410000 \
    && ./configure --prefix=/usr/local \
    && make \
    && make install \
    && cd .. \
    && rm -rf sqlite-autoconf-3410000 sqlite-autoconf-3410000.tar.gz

# Atualizar links do SQLite
RUN ldconfig

# Habilitar extensões PHP
RUN docker-php-ext-install pdo pdo_sqlite

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Instalar dependências do Laravel
COPY . /var/www/html
RUN composer install
RUN php artisan migrate

# Configurar permissões de armazenamento e cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache


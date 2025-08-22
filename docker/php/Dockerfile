FROM php:8.3-fpm

COPY php.ini /usr/local/etc/php/

# UID/GIDを受け取る(wsl対応、ファイル権限問題対策)
ARG UID=501
ARG GID=20

# 基本拡張とビルドに必要なツール群
RUN apt update \
  && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
  && docker-php-ext-install pdo_mysql zip

# UID/GIDをwww-dataに適用 (wsl対応、ファイル権限問題対策)
RUN usermod -u ${UID} www-data && groupmod -g ${GID} www-data

# Composer
RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update

WORKDIR /var/www

# これを最後に追加
USER www-data


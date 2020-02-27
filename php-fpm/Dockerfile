# 在 FROM 命令之前声明的变量,在 FROM 之后不能使用,需要再次声明
ARG PHP_VERSION
FROM php:${PHP_VERSION}-fpm

# 从 .env 文件中定义的变量
# ARG PHP_VERSION # 需要再次声明 PHP_VERSION
ARG TIME_ZONE
ARG CHANGE_SOURCE
ARG UBUNTU_SOURCE
ARG COMPOSER_SOURCE
ARG COMPOSER_PHAR_SOURCE
ARG PHP_FPM_PECL_PATH
ARG PHP_FPM_INSTALL_PDO_MYSQL
ARG PHP_FPM_INSTALL_GD
ARG PHP_FPM_INSTALL_BCMATH
ARG PHP_FPM_INSTALL_PHPREDIS
ARG PHP_FPM_INSTALL_COMPOSER

## 设置时区
RUN ln -snf /usr/share/zoneinfo/$TIME_ZONE /etc/localtime && echo $TIME_ZONE > /etc/timezone

## 更改 apt 源地址
# sed -i 's/原字符串/新字符串/' /path/to/file
RUN if [ ${CHANGE_SOURCE} = true ]; then \
    sed -i "s/deb.debian.org/${UBUNTU_SOURCE}/" /etc/apt/sources.list && \
    sed -i "s/security.debian.org/${UBUNTU_SOURCE}/" /etc/apt/sources.list && \
    sed -i "s/security-cdn.debian.org/${UBUNTU_SOURCE}/" /etc/apt/sources.list \
;fi

## 安装软件
# curl git zip unzip 运行composer需要的依赖
RUN apt-get update && apt-get install -yqq \
    curl \
    git \
    zip \
    unzip \
    > /dev/null

## docker-php-ext-install 方式 安装 php 扩展
# https://github.com/mlocati/docker-php-extension-installer
# docker-php-ext-enable 将扩展配置文件写入 /usr/local/etc/php/conf.d/*.ini

RUN if [ ${PHP_FPM_INSTALL_PDO_MYSQL} = true ]; then \
    docker-php-ext-install pdo_mysql > /dev/null \
;fi

RUN if [ ${PHP_FPM_INSTALL_GD} = true ]; then \
    apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev > /dev/null \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd > /dev/null \
;fi

RUN if [ ${PHP_FPM_INSTALL_BCMATH} = true ]; then \
    docker-php-ext-install bcmath > /dev/null \
;fi

## pecl 联网方式安装, 国内访问很慢, 可以把 扩展包下载到 /lemp/php-fpm/pecl/ 目录下,加快安装.
# RUN if [ ${PHP_FPM_INSTALL_PHPREDIS} = true ]; then \
#     if [ $(php -r "echo PHP_MAJOR_VERSION;") = "5" ]; then \
#       pecl install redis-4.3.0; \
#     else \
#       pecl install redis; \
#     fi \
#     && docker-php-ext-enable redis \
#     && php -m | grep -q 'redis' \
# ;fi

# ## pecl 首选离线方式安装,如果无离线包,则使用联网方式安装
COPY ./pecl/* $PHP_FPM_PECL_PATH

RUN if [ ${PHP_FPM_INSTALL_PHPREDIS} = true ]; then \
    if [ $(php -r "echo PHP_MAJOR_VERSION;") = "5" ]; then \
      if [ -f ${PHP_FPM_PECL_PATH}redis-4.3.0.tgz ]; then \
        pecl -q install -o -f ${PHP_FPM_PECL_PATH}redis-4.3.0.tgz; \
      else \
        pecl -q install -o -f redis-4.3.0; \
      fi \
    else \
      if [ -f "${PHP_FPM_PECL_PATH}redis-5.1.1.tgz" ]; then \
        pecl -q install -o -f ${PHP_FPM_PECL_PATH}redis-5.1.1.tgz; \
      else \
        pecl -q install -o -f redis; \
      fi \
    fi \
    && docker-php-ext-enable redis \
    && php -m | grep -q 'redis' \
;fi

# 安装 composer 并 设置镜像地址
RUN if [ ${PHP_FPM_INSTALL_COMPOSER} = true ]; then \
    curl -sL -o /usr/local/bin/composer $COMPOSER_PHAR_SOURCE && \
    chmod 751 /usr/local/bin/composer && \
    composer config -g repo.packagist composer $COMPOSER_SOURCE && \
    composer config -gl | grep repositories \
;fi

# 清理 apt
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog
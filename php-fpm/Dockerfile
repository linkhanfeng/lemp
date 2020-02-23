FROM php:7.2-fpm

# 从 .env 文件中定义的变量
ARG TIME_ZONE
ARG CHANGE_SOURCE
ARG UBUNTU_SOURCE
ARG COMPOSER_SOURCE
ARG COMPOSER_PHAR_SOURCE

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
    unzip

## 安装 php 扩展
# bcmath pdo_mysql 运行 laravel 需要的依赖
RUN docker-php-ext-install \
    bcmath \
    pdo_mysql

# 安装 composer 并 设置镜像地址
RUN curl -sL -o /usr/local/bin/composer $COMPOSER_PHAR_SOURCE && \
    chmod 751 /usr/local/bin/composer && \
    composer config -g repo.packagist composer $COMPOSER_SOURCE && \
    composer config -gl | grep repositories

# 清理apt
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog
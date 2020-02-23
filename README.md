## app

## web

## db

## docker-compose

```
docker-compose up --build // 修改yml重新build
```

```
- restart: always # 随系统启动,自动重启
```
## 常用命令

```
docker-compose exec app bash

docker exec -it <containerId> bash
```

## 临时容器

composer create-project --prefer-dist laravel/laravel app "5.8.*"

docker run -it --rm php:7.2-fpm bash

docker run -d --name php56 php:5.6-fpm && \
docker run -d --name php70 php:7.0-fpm && \
docker run -d --name php71 php:7.1-fpm && \
docker run -d --name php72 php:7.2-fpm && \
docker run -d --name php73 php:7.3-fpm && \
docker run -d --name php74 php:7.4-fpm

docker cp php56:/usr/local/etc/php/php.ini-production ./php-fpm/php5.6.ini && \
docker cp php70:/usr/local/etc/php/php.ini-production ./php-fpm/php7.0.ini && \
docker cp php71:/usr/local/etc/php/php.ini-production ./php-fpm/php7.1.ini && \
docker cp php72:/usr/local/etc/php/php.ini-production ./php-fpm/php7.2.ini && \
docker cp php73:/usr/local/etc/php/php.ini-production ./php-fpm/php7.3.ini && \
docker cp php74:/usr/local/etc/php/php.ini-production ./php-fpm/php7.4.ini
# pecl
国内访问 https://pecl.php.net/ 非常慢,也没有找到 pecl 的国内镜像;

为了加快镜像的创建速度,可以将 php 扩展文件,放置到这个目录中.加快镜像构建速度.

需要手动修改 Dockerfile 格式如下:

```

RUN if [ ${PHP_FPM_INSTALL_PHPREDIS} = true ]; then \
    if [ -f "${PHP_FPM_PECL_PATH}redis-5.1.1.tgz" ]; then \
      pecl -q install -o -f ${PHP_FPM_PECL_PATH}redis-5.1.1.tgz; \
    else \
      pecl -q install -o -f redis; \
    fi \
    && docker-php-ext-enable redis \
    && php -m | grep -q 'redis' \
;fi

```
ARG NGINX_VERSION
FROM nginx:${NGINX_VERSION}

# 从 .env 文件中定义的变量
ARG TIME_ZONE
ARG NGINX_PHP_UPSTREAM_CONTAINER
ARG NGINX_PHP_UPSTREAM_PORT

# 设置时区
RUN ln -snf /usr/share/zoneinfo/$TIME_ZONE /etc/localtime && echo $TIME_ZONE > /etc/timezone

# 拷贝 nginx 主配置文件
COPY ./nginx.conf /etc/nginx/

# 设置 upstream 配置文件 和 备份默认nginx配置文件
RUN echo "upstream php-upstream { server ${NGINX_PHP_UPSTREAM_CONTAINER}:${NGINX_PHP_UPSTREAM_PORT}; }" > /etc/nginx/conf.d/upstream.conf \
  && mv /etc/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf.copyback
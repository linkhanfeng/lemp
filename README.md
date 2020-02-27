<!-- MarkdownTOC -->

- lemp doc
    - 开始
    - services
        - mysql server
        - nginx server
        - php-fpm server
        - redis server
    - 常用命令
    - 常见问题

<!-- /MarkdownTOC -->

# lemp doc

## 开始
1.  配置文件在 .env
2.  `cd /path/to/lemp && docker-compose up -d`

## services

### mysql server

配置文件 /lemp/mysql/my.cnf

### nginx server

站点配置文件 /lemp/nginx/sites

主要配置文件 /lemp/nginx/nginx.conf

### php-fpm server

pecl 离线包 /lemp/php-fpm/pecl 详细安装方法见目录说明文件

php 配置文件,修改对应的版本即可

### redis server
注意: 密码在 redis.conf 配置文件中

## 常用命令

```
docker-compose up -d
docker-compose down
docker-compose build --no-cache workspace
docker-compose up --build // 修改yml重新build
docker-compose exec workspace bash
docker exec -it <containerId> bash
// 临时容器
docker run -it --rm php:7.2-fpm bash
// 拷贝文件: 从容器中拷贝到宿主机
docker cp mycontainer:/path /path
// 拷贝文件: 从宿主机拷贝到容器
docker cp /path mycontainer:/path
```

## 常见问题

清理缓存和日志
``` bash
rm -fr ~/.lemp/*
rm -fr lemp/logs/*
```
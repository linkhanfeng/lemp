ARG REDIS_VERSION
FROM redis:${REDIS_VERSION}

# 从 .env 文件中定义的变量
ARG TIME_ZONE

## 设置时区
RUN ln -snf /usr/share/zoneinfo/$TIME_ZONE /etc/localtime && echo $TIME_ZONE > /etc/timezone

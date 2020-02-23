FROM mysql:5.7

# 设置时区
ARG TIME_ZONE
# 更改时区
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

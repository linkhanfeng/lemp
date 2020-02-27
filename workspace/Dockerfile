# https://github.com/Laradock/workspace
ARG PHP_VERSION

FROM laradock/workspace:2.6.1-${PHP_VERSION}

# 从 .env 文件中定义的变量
ARG TIME_ZONE
ARG CHANGE_SOURCE
ARG UBUNTU_SOURCE
ARG COMPOSER_SOURCE
ARG PHP_VERSION

ARG WORKSPACE_INSTALL_NODE
ARG WORKSPACE_NODE_VERSION
ARG WORKSPACE_NVM_NODEJS_ORG_MIRROR
ARG WORKSPACE_NPM_REGISTRY
ARG WORKSPACE_INSTALL_VUE_CLI

## 设置时区
RUN ln -snf /usr/share/zoneinfo/$TIME_ZONE /etc/localtime && echo $TIME_ZONE > /etc/timezone

## 更改 apt 源地址
# sed -i 's/原字符串/新字符串/' /path/to/file
RUN if [ ${CHANGE_SOURCE} = true ]; then \
    sed -i "s/deb.debian.org/${UBUNTU_SOURCE}/" /etc/apt/sources.list && \
    sed -i "s/security.debian.org/${UBUNTU_SOURCE}/" /etc/apt/sources.list && \
    sed -i "s/security-cdn.debian.org/${UBUNTU_SOURCE}/" /etc/apt/sources.list \
;fi

# 创建用户
ARG PUID=1000
ARG PGID=1000
RUN groupadd -g ${PGID} lemp && \
  # -g: 组 -m:创建用户家目录
  useradd -u ${PUID} -g lemp -m lemp && \
  # -p:用户密码 -s: 用户使用的shell
  usermod -p "lemp" lemp -s /bin/bash

# 设置 composer 镜像地址
RUN composer config -g repo.packagist composer $COMPOSER_SOURCE && \
    composer config -gl | grep repositories

# 使用非 root 用户安装 nodejs
USER lemp

# 安装 nvm
# . ~/.bashrc 等同于 source filename
ENV NVM_DIR /home/lemp/.nvm
RUN if [ ${WORKSPACE_INSTALL_NODE} = true ]; then \
    # 安装 nvm
    git clone https://gitee.com/mirrors/nvm.git $NVM_DIR \
    && cd $NVM_DIR && git checkout v0.35.2 2>/dev/null \
    && . $NVM_DIR/nvm.sh \
    && NVM_NODEJS_ORG_MIRROR=$WORKSPACE_NVM_NODEJS_ORG_MIRROR nvm install ${WORKSPACE_NODE_VERSION} \
    && nvm use ${WORKSPACE_NODE_VERSION} \
    && nvm alias ${WORKSPACE_NODE_VERSION} \
    && if [ ${WORKSPACE_NPM_REGISTRY} ]; then \
    npm config set registry ${WORKSPACE_NPM_REGISTRY} \
    ;fi \
    && if [ ${WORKSPACE_INSTALL_VUE_CLI} = true ]; then \
    npm install -g @vue/cli \
    ;fi \
;fi

# 添加 nvm 到 .bashrc
RUN if [ ${WORKSPACE_INSTALL_NODE} = true ]; then \
    echo "" >> ~/.bashrc && \
    echo 'export NVM_DIR="$HOME/.nvm"' >> ~/.bashrc && \
    echo '[ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"  # This loads nvm' >> ~/.bashrc \
;fi

USER root

# 添加 nvm 到 root 用户的 .bashrc
RUN if [ ${WORKSPACE_INSTALL_NODE} = true ]; then \
    echo "" >> ~/.bashrc && \
    echo 'export NVM_DIR="/home/lemp/.nvm"' >> ~/.bashrc && \
    echo '[ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"  # This loads nvm' >> ~/.bashrc \
;fi

RUN if [ ${WORKSPACE_NPM_REGISTRY} ]; then \
    # . ~/.bashrc 等价于 source .bashrc; 报错 shopt: not found, sh 无 shopt 命令,但实际上bash有;不影响.
    . ~/.bashrc 2>/dev/null && npm config set registry ${WORKSPACE_NPM_REGISTRY} \
;fi

# USER root

# # Clean up
# RUN apt-get clean && \
#     rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
#     rm /var/log/lastlog /var/log/faillog

# # Set default work directory
# WORKDIR /var/www
